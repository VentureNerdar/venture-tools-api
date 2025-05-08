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
            $serviceAccountPath = storage_path('venture-notification-firebase-adminsdk-fbsvc-ca6b04f0e4.json');

            if (!file_exists($serviceAccountPath)) {
                Log::error('Firebase service account file not found');
                return;
            }

            $factory = (new Factory)->withServiceAccount($serviceAccountPath);
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
