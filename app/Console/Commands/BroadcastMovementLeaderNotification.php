<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\UserDevice;
use App\Services\FirebaseService;

class BroadcastMovementLeaderNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:broadcast-movement-leader-notification
                            {movement_id}
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification to all leaders in a movement';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $movementId = $this->argument('movement_id');
        $movementUsers = User::where('movement_id', $movementId)
            ->where('user_role_id', 3)
            ->pluck('id')
            ->toArray();
        $tokens = UserDevice::whereIn('user_id', $movementUsers)->whereNotNull('notification_token')->pluck('notification_token')->toArray();
        $title = 'New Disciple Maker being registered';
        $body = 'Head over to the user page to verify them';
        if ($tokens) {
            $fcm = app(FirebaseService::class);
            $fcm->sendMulticast(
                $tokens,
                $title,
                $body,
                []
            );
        }
    }
}
