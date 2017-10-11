<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')->hourly();

        $schedule->command('route:list')->everyTenMinutes();

        $schedule->exec('ls -al')->mondays()->at('10:00');

        $schedule->exec('date')->mondays()->at('10:00');

        $schedule->exec('cal')->weekdays()->at('10:00')->description('Show the calendar');

        $schedule->exec('free -m')->monthlyOn(5)->at('10:00');

        $schedule->exec('uptime')->everyThirtyMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
