<?php

namespace App\Console\Commands;

use App\Events\NotificationEvent;
use App\Models\Setting;
use App\Models\UserDevice;
use App\Models\User;
use App\Models\SystemLanguage;
use App\Services\FirebaseService;
use Illuminate\Console\Command;

class BroadcastNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:broadcast-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notifications to Church Planters';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // Get notification settings
            $settings = Setting::where('name', 'notification_interval')->first();
            if (!$settings) {
                $this->error('Notification settings not found');
                return;
            }

            $value = json_decode($settings->value, true);
            if (!isset($value['enabled']) || !$value['enabled']) {
                $this->info('Notifications are disabled');
                return;
            }

            // Get languages
            $languages = SystemLanguage::all();

            // loop through each language
            foreach ($languages as $language) {
                // get user devices where user_id's preferred_language_id is the current language
                $tokens = UserDevice::whereHas('user', function ($query) use ($language) {
                    // $query->where('preferred_language_id', $language->id);
                    $query->where(function ($q) use ($language) {
                        $q->where('preferred_language_id', $language->id)
                            ->orWhere(function ($q) {
                                $q->whereNull('preferred_language_id')->where('id', 1);
                            });
                    });
                })->whereNotNull('notification_token')->pluck('notification_token')->toArray();

                // notificationMessage is array. it has { id, title, message } need to get the notification message for the current language
                $notificationMessage = $value['notificationMessage'][$language->id];
                $notificationMessage = collect($value['notificationMessage'])
                    ->firstWhere('id', $language->id)
                    ?? $value['notificationMessage'][1]
                    ?? ['id' => 1, 'title' => 'Default Title', 'message' => 'Default Message'];

                // send notification to the tokens
                $fcm = app(FirebaseService::class);
                $fcm->sendMulticast(
                    $tokens,
                    $notificationMessage['title'],
                    $notificationMessage['message'],
                    []
                );
            }

            $this->info("Notifications sent successfully.");

            /*
            // Get all Church Planters' device tokens
            $tokens = UserDevice::whereHas('user', function ($query) {
                $query->where('user_role_id', 4);
            })
                ->whereNotNull('notification_token')
                ->pluck('notification_token')
                ->toArray();

            if (empty($tokens)) {
                $this->info('No Church Planters with notification tokens found');
                return;
            }

            // Send to all tokens at once using FCM multicast
            $fcm = app(FirebaseService::class);
            $result = $fcm->sendMulticast(
                $tokens,
                $value['title'] ?? 'Scheduled Notification',
                $value['notificationMessage'] ?? 'This is a scheduled notification',
                []
            );
            $this->info("Notifications sent successfully. Success: {$result['success']}, Failed: {$result['failure']}");

            */
        } catch (\Exception $e) {
            $this->error('Failed to send notifications: ' . $e->getMessage());
        }
    }
}
