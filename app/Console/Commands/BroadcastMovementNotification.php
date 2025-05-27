<?php

namespace App\Console\Commands;

use App\Models\SystemLanguage;
use App\Models\User;
use App\Models\UserDevice;
use App\Services\FirebaseService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BroadcastMovementNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:broadcast-movement-notification
                            {title}
                            {body}
                            ';

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
        $authUser = Auth::user();
        $movementUsers = User::where('movement_id', $authUser->movement_id)->get()->pluck('id')->toArray();
        $tokens = UserDevice::whereIn('user_id', $movementUsers)->whereNotNull('notification_token')->pluck('notification_token')->toArray();
        $title = $this->argument('title');
        $body = $this->argument('body');
        $fcm = app(FirebaseService::class);
        $fcm->sendMulticast(        // send notification using using movement users id and fetch user device using this ids and send notification according to preferred language and  Default is english 
            $tokens,
            $title,
            $body,
            []
        );
    }
}
