<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserNotificationToken;
use Kreait\Firebase\Messaging\CloudMessage;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    /**
     * Register a new notification token for a user
     */
    public function registerToken(User $user, string $token, ?string $deviceMacAddress = null, ?float $latitude = null, ?float $longitude = null)
    {
        try {
            // Check if token already exists
            $existingToken = UserNotificationToken::where('token', $token)->first();

            if ($existingToken) {
                // Update existing token
                $existingToken->update([
                    'user_id' => $user->id,
                    'device_mac_address' => $deviceMacAddress,
                    'login_date' => now(),
                    'latitude' => $latitude,
                    'longitude' => $longitude
                ]);
                return $existingToken;
            }

            // Create new token
            return UserNotificationToken::create([
                'user_id' => $user->id,
                'token' => $token,
                'device_mac_address' => $deviceMacAddress,
                'login_date' => now(),
                'latitude' => $latitude,
                'longitude' => $longitude
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to register notification token: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Send a notification to a specific user
     */
    public function sendToUser(User $user, string $title, string $body, array $data = [])
    {
        try {
            $tokens = $user->notificationTokens()->pluck('token')->toArray();

            if (empty($tokens)) {
                Log::warning("No notification tokens found for user {$user->id}");
                return false;
            }

            foreach ($tokens as $token) {
                $this->firebaseService->sendNotification($token, $title, $body, $data);
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send notification: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Send a notification to multiple users
     */
    public function sendToUsers(array $users, string $title, string $body, array $data = [])
    {
        try {
            foreach ($users as $user) {
                $this->sendToUser($user, $title, $body, $data);
            }
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send notifications to multiple users: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Remove a notification token
     */
    public function removeToken(string $token)
    {
        try {
            return UserNotificationToken::where('token', $token)->delete();
        } catch (\Exception $e) {
            Log::error('Failed to remove notification token: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get all tokens for a user
     */
    public function getUserTokens(User $user)
    {
        return $user->notificationTokens()->get();
    }
}
