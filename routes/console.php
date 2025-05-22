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

    $time = $value['time'];

    // Check interval-specific conditions first
    if ($value['intervalUnit'] === 'weeks') {
        if (!isset($time['dayOfWeek']) || now()->dayOfWeek !== (int)$time['dayOfWeek']) {

            return false;
        }
    }

    if ($value['intervalUnit'] === 'months') {

        $time = $value['time'];
        if (!isset($time['dayOfMonth']) && now()->day != (int)$time['dayOfMonth']) {
            return false;
        }

        // return false;
    }

    // Common Time Check (for all interval types)
    $scheduledTime = now()->copy()->startOfDay()->addHours($time['hour'])->addMinutes($time['minute']);

    // Handle PM
    if (strtolower($time['ampm']) === 'pm' && $time['hour'] < 12) {
        $scheduledTime->addHours(12);
    }

    if (now()->lessThan($scheduledTime)) {
        return false;
    }

    $intervalValue = $value['intervalValue'] ?? 1;
    $intervalUnit = $value['intervalUnit'] ?? 'weeks';

    // Get last run time from cache
    $lastRunString = cache()->get('last_notification_run');
    $now = now();

    if (!$lastRunString) {
        cache()->put('last_notification_run', $scheduledTime);
        return true;
    }

    $lastRun = \Carbon\Carbon::parse($lastRunString);

    // Calculate next run time based on unit
    switch ($intervalUnit) {
        case 'days':
            $nextRun = $lastRun->copy()->addDays($intervalValue);
            break;
        case 'weeks':
            $nextRun = $lastRun->copy()->addWeeks($intervalValue);
            break;
        case 'months':
            $nextRun = $lastRun->copy()->addMonths($intervalValue);
            break;
        default:
            return false;
    }

    if ($now->gte($nextRun)) {
        cache()->put('last_notification_run', $now);
        return true;
    }

    return false;
})->everyMinute();


// Schedule::command(BroadcastNotification::class)->everyTwoSeconds();

// Schedule::command(BroadcastNotification::class)->everyOneWeek();
