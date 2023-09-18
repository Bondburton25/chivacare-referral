<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\PatientReferralCommission::class,
        Commands\PatientStayOneMonth::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('app:patient-stay-one-month')->everyMinute();
        // $schedule->call(function () {
        //     $patientAdmitStage = DB::table('stages')->where('step', 5)->first();
        //     $stayOneMonthStage = DB::table('stages')->where('step', 6)->first();
        //     DB::table('patients')->where('arrive_date_time', '<=', Carbon::now()->subDays(30))->where('stage_id', $patientAdmitStage->id)->update(['stage_id' => $stayOneMonthStage->id, 'admission_date_one_month' => today()]);
        // })->everyMinute();
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
