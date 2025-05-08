<?php

namespace App\Console\Commands;

use App\Events\NotificationEvent;
use App\Models\Setting;
use App\Models\UserDevice;
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
        } catch (\Exception $e) {
            $this->error('Failed to send notifications: ' . $e->getMessage());
        }
    }
}
