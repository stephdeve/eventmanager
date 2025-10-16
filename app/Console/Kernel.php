<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array<int, class-string>
     */
    protected $commands = [
        \App\Console\Commands\ExpireSubscriptions::class,
        \App\Console\Commands\SendEventReminders::class,
        \App\Console\Commands\SendSubscriptionReminders::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Expire subscriptions hourly (safe and idempotent)
        $schedule->command('subscriptions:expire')->hourly();

        // Send participant reminders (J-7/J-1/H-3)
        $schedule->command('events:send-reminders')->hourly();

        // Send organizer subscription renewal reminders (J-7/J-3/J-1)
        $schedule->command('subscriptions:send-reminders')->dailyAt('09:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
