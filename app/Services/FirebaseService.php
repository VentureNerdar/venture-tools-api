<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Exception\MessagingException;
use Illuminate\Support\Facades\Log;

class FirebaseService
{
    protected $messaging;

    public function __construct()
    {
        try {
            $credentials = [
                'type' => env('FIREBASE_CREDENTIALS_TYPE'),
                'project_id' => env('FIREBASE_PROJECT_ID'),
                'private_key_id' => env('FIREBASE_PRIVATE_KEY_ID'),
                'private_key' => str_replace('\n', "\n", env('FIREBASE_PRIVATE_KEY')),
                'client_email' => env('FIREBASE_CLIENT_EMAIL'),
                'client_id' => env('FIREBASE_CLIENT_ID'),
                'auth_uri' => env('FIREBASE_AUTH_URI'),
                'token_uri' => env('FIREBASE_TOKEN_URI'),
                'auth_provider_x509_cert_url' => env('FIREBASE_AUTH_PROVIDER_CERT_URL'),
                'client_x509_cert_url' => env('FIREBASE_CLIENT_CERT_URL')
            ];

            $factory = (new Factory)->withServiceAccount($credentials);
            $this->messaging = $factory->createMessaging();
        } catch (\Exception $e) {
            Log::error('Failed to initialize Firebase: ' . $e->getMessage());
        }
    }

    /**
     * Send a notification to a specific device
     */
    public function sendNotification(string $token, string $title, string $body, array $data = [])
    {
        try {
            if (!$this->messaging) {
                throw new \Exception('Firebase messaging not initialized');
            }

            $message = CloudMessage::withTarget('token', $token)
                ->withNotification([
                    'title' => $title,
                    'body' => $body
                ]);

            if (!empty($data)) {
                $message = $message->withData($data);
            }

            $this->messaging->send($message);
            return true;
        } catch (MessagingException $e) {
            Log::error('Firebase messaging error: ' . $e->getMessage());
            throw $e;
        } catch (\Exception $e) {
            Log::error('Failed to send notification: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Send a notification to multiple devices
     */
    public function sendMulticast(array $tokens, string $title, string $body, array $data = [])
    {
        try {
            if (!$this->messaging) {
                throw new \Exception('Firebase messaging not initialized');
            }

            $message = CloudMessage::new()
                ->withNotification([
                    'title' => $title,
                    'body' => $body
                ]);

            if (!empty($data)) {
                $message = $message->withData($data);
            }

            $sendReport = $this->messaging->sendMulticast($message, $tokens);

            return [
                'success' => $sendReport->successes()->count(),
                'failure' => $sendReport->failures()->count()
            ];
        } catch (MessagingException $e) {
            Log::error('Firebase messaging error: ' . $e->getMessage());
            throw $e;
        } catch (\Exception $e) {
            Log::error('Failed to send multicast notification: ' . $e->getMessage());
            throw $e;
        }
    }
}
