<?php

use App\Console\Commands\BroadcastNotification;
use App\Models\Setting;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Schedule notifications based on settings
Schedule::command(BroadcastNotification::class)->everyMinute()->when(function () {
    $settings = Setting::where('name', 'notification_interval')->first();
    if (!$settings) {
        return false;
    }

    $value = json_decode($settings->value, true);
    if (!isset($value['enabled']) || !$value['enabled']) {
        return false;
    }

    // Get the interval value and unit
    $intervalValue = $value['intervalValue'] ?? 1;
    $intervalUnit = $value['intervalUnit'] ?? 'week';

    // Calculate the next run time based on the interval
    $lastRun = cache()->get('last_notification_run');
    if (!$lastRun) {
        cache()->put('last_notification_run', now());
        return true;
    }

    $nextRun = $lastRun->add($intervalValue, $intervalUnit);
    if (now()->gte($nextRun)) {
        cache()->put('last_notification_run', now());
        return true;
    }

    return false;
});

// Schedule::command(BroadcastNotification::class)->everyTwoSeconds();

// Schedule::command(BroadcastNotification::class)->everyOneWeek();
