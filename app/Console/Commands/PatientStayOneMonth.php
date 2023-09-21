<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Patient;

class PatientStayOneMonth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:patient-stay-one-month';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update patient stage if they stay for 30 day';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $patientAdmitStage = DB::table('stages')->where('step', 5)->first();
        $stayOneMonthStage = DB::table('stages')->where('step', 6)->first();

        $patients = Patient::where('arrive_date_time', '<=', Carbon::now()->subDays(30))->where('stage_id', $patientAdmitStage->id)->where('end_service_at', null)->get();

        foreach ($patients as $patient) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.line.me/v2/bot/message/push",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => '{
                    "to": "' . $patient->referred_by->auth_provider->provider_id . '",
                    "messages": [{
                    "type": "flex",
                    "altText": "'.__('Update on the patient referral process') .' '."$patient->full_name".'",
                    "contents": {
                        "type": "bubble",
                        "size": "mega",
                        "header": {
                            "type": "box",
                            "layout": "vertical",
                            "contents": [
                                {
                                    "type": "box",
                                    "layout": "horizontal",
                                    "contents": [
                                        {
                                            "type": "box",
                                            "layout": "vertical",
                                            "contents": [
                                                {
                                                    "type": "text",
                                                    "text": "'.__('Patient referral information').'",
                                                    "color": "#FFFFFF"
                                                },
                                                {
                                                    "type": "text",
                                                    "text": "'.$patient->full_name.'",
                                                    "flex": 1,
                                                    "color": "#FFFFFF",
                                                    "gravity": "bottom"
                                                }
                                            ],
                                            "flex": 6,
                                            "alignItems": "flex-start",
                                            "justifyContent": "space-between",
                                            "margin": "none"
                                        }
                                    ]
                                }
                            ],
                            "paddingAll": "20px",
                            "backgroundColor": "#198754",
                            "spacing": "md",
                            "paddingTop": "22px"
                        },
                        "body": {
                            "type": "box",
                            "layout": "baseline",
                            "contents": [
                                {
                                    "type": "text",
                                    "text": "'.__('Current stage').'",
                                    "color": "#b7b7b7",
                                    "size": "xs",
                                    "flex": 1
                                },
                                {
                                    "type": "text",
                                    "text": "'.$stayOneMonthStage->name.'",
                                    "flex": 2,
                                    "wrap": true,
                                    "size": "sm"
                                }
                            ]
                        },
                        "footer": {
                            "type": "box",
                            "layout": "vertical",
                            "spacing": "sm",
                            "contents": [
                                {
                                    "type": "button",
                                    "style": "primary",
                                    "height": "sm",
                                    "action": {
                                        "type": "uri",
                                        "label": "'.__('View patient information').'",
                                        "uri": "'.url('/patients/'.$patient->id.'').'"
                                    },
                                    "color": "#E7A109"
                                },
                                {
                                    "type": "box",
                                    "layout": "vertical",
                                    "contents": [],
                                    "margin": "sm"
                                }
                            ],
                            "flex": 0
                        }
                    }
                }
            ]
        }',
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer GtVt/MRkohh1NDhA0Acjwh4rkjHMu8dIXaNjA5F5eKrMkn9muvgkqhiR0vPXfVyFgFfMqU5UAX28VFUrdd6tSeNgTs9HaZe/RxGcM5uLVXKP+0VHvS951/Nnd73cFsYTBglR4mPCN42S1269jWuzFgdB04t89/1O/w1cDnyilFU=",
                "cache-control: no-cache",
                "content-type: application/json; charset=UTF-8",
            ),
        ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
        }
        DB::table('patients')->where('end_service_at', null)->where('arrive_date_time', '<=', Carbon::now()->subDays(30))->where('stage_id', $patientAdmitStage->id)->update(['stage_id' => $stayOneMonthStage->id, 'admission_date_one_month' => today()]);
    }
}
