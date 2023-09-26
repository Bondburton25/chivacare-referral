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
        Commands\PatientStayOneMonth::class,
        // Commands\PatientStayTwoMonths::class,
        // Commands\PatientStayThreeMonths::class,
        // Commands\PatientReferralFeeOneMonth::class,
        // Commands\PatientReferralFeeTwoMonths::class,
        // Commands\PatientReferralFeeThreeMonths::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('app:patient-stay-one-month')->daily();
        // $schedule->command('app:patient-stay-two-months')->dailyAt('12:00');
        // $schedule->command('app:patient-stay-three-months')->dailyAt('12:00');
        // $schedule->command('app:patient-stay-three-months')->dailyAt('10:15');
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
