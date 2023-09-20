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
        Commands\PatientReferralFeeOneMonth::class,
        // Commands\PatientReferralFeeTwoMonths::class,
        // Commands\PatientReferralFeeThreeMonths::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('app:patient-stay-one-month')->dailyAt('14:15');
        // $schedule->command('app:patient-stay-two-months')->dailyAt('10:15');
        // $schedule->command('app:patient-stay-three-months')->dailyAt('10:15');
        $schedule->command('app:patient-referral-fee-one-month')->monthlyOn(20, '14:15');
        // $schedule->command('app:patient-referral-Fee-two-months')->monthlyOn(20, '10:15');
        // $schedule->command('app:patient-referral-Fee-three-months')->monthlyOn(20, '10:15');
        // $schedule->command('app:patient-stay-one-month')->everyMinute();
        // $schedule->command('app:patient-stay-two-months')->everyMinute();
        // $schedule->command('app:patient-stay-three-months')->everyMinute();

        // $schedule->command('app:patient-referral-Fee-two-months')->everyMinute();
        // $schedule->command('app:patient-referral-Fee-three-months')->everyMinute();
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
