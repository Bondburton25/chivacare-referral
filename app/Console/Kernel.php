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
        Commands\PatientAdventDelay::class,
        Commands\PatientStayOneMonth::class,
        Commands\PatientStayTwoMonths::class,
        Commands\PatientStayThreeMonths::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('app:patient-advent-delay')->dailyAt('09:00');
        $schedule->command('app:patient-stay-one-month')->dailyAt('09:00');
        $schedule->command('app:patient-stay-two-months')->dailyAt('09:00');
        $schedule->command('app:patient-stay-three-months')->dailyAt('09:00');
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
