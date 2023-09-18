<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use App\Models\Patient;

class PatientReferralCommission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:patient-referral-commission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update patient stage if they stay for 30 day';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // \Log::info("Cron is working fine!");
        // \Log::info("My Schedule Task");
        return 0;
        // $stayOneMonthStage = DB::table('stages')->where('step', 6)->first();
        // Patient::where('arrive_date_time', '<=', Carbon::now()->subDays(30))->update(['stage_id' => $stayOneMonthStage->id]);
    }
}
