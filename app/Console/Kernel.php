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
        Commands\PatientStayTwoMonths::class,
        Commands\PatientStayThreeMonths::class,
        Commands\PatientReferralCommissionOneMonth::class,
        Commands\PatientReferralCommissionTwoMonths::class,
        Commands\PatientReferralCommissionThreeMonths::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('app:patient-stay-one-month')->dailyAt('10:00');
        $schedule->command('app:patient-stay-two-months')->dailyAt('10:00');
        $schedule->command('app:patient-stay-three-months')->dailyAt('10:00');
        $schedule->command('app:patient-referral-commission-one-month')->monthlyOn(20, '10:00');
        $schedule->command('app:patient-referral-commission-two-months')->monthlyOn(20, '10:00');
        $schedule->command('app:patient-referral-commission-three-months')->monthlyOn(20, '10:00');
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
