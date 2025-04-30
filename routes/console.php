<?php

use App\Console\Commands\BroadcastMyEvent;
use App\Console\Commands\BroadcastNotification;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Schedule::command(BroadcastNotification::class)->everyTwoSeconds();

Schedule::command(BroadcastNotification::class)->everyTwoSeconds();
