<?php

namespace App\Console\Commands;

use App\Models\Setting;
use App\Models\UserDevice;
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

                    if ($language->id == 1) {
                        $query->where(function ($q) use ($language) {
                            $q->where('preferred_language_id', $language->id)
                                ->orWhere(function ($q) {
                                    $q->whereNull('preferred_language_id');
                                });
                        });
                    } else {
                        $query->where(function ($q) use ($language) {
                            $q->where('preferred_language_id', $language->id);
                        });
                    }
                })->whereNotNull('notification_token')->pluck('notification_token')->toArray();
                if (empty($tokens)) {
                    continue;
                }
                $title = $value['notificationMessage'][$language->name]['title'];
                $body = $value['notificationMessage'][$language->name]['body'];

                $fcm = app(FirebaseService::class);
                $fcm->sendMulticast(
                    $tokens,
                    $title,
                    $body,
                    []
                );
            }

            $this->info("Notifications sent successfully.");
        } catch (\Exception $e) {
            $this->error('Failed to send notifications: ' . $e->getMessage());
        }
    }
}
