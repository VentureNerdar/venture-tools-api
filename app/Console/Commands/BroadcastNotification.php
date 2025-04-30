<?php

namespace App\Console\Commands;

use App\Events\NotificationEvent;
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
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // broadcast(new NotificationEvent('⏰ Ping from Laravel!'));
        // $message = 'Scheduled notification sent at ' . now();

        // broadcast(new NotificationEvent($message))->toOthers();

        // 🔁 Optionally send push via Firebase
        $fcm = app(FirebaseService::class);
        $targetToken = 'e7OOAOou5pE4D98eYU-Ady:APA91bFVGcmYE5S_MMRgVRbvwtwHFN6c1HmLx2pxMTJ5i-AYEMvsXezan5uyytJawuNVBwo4G1aKZnKg8I9Wet5NHlR6pnNMZ-PU2_fITqQ_aCz_UrgUUv0'; // load token(s) from DB or config
        $title = 'Testing Title';
        $body = 'Testing Message';
        $fcm->sendNotification($targetToken, $title, $body, []);

        $this->info('Notification broadcasted and FCM sent.');
        //
    }
}
