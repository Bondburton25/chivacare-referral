<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Patient;

class PatientStayThreeMonths extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:patient-stay-three-months';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update patient stage if they stay for 90 day';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $stayTwoMonthsStage = DB::table('stages')->where('step', 7)->first();
        $stayThreeMonthsStage = DB::table('stages')->where('step', 8)->first();

        $patients = Patient::where('arrive_date_time', '<=', Carbon::now()->subDays(90))->where('stage_id', $stayTwoMonthsStage->id)->get();

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
                                    "text": "'.$stayThreeMonthsStage->name.'",
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
                "Authorization: Bearer QoUKeR+rPCjaHolU2Cv0kYXvWHx4Xl366O2PqbctqC6zSUv0F9i+U0/iupxgi/WUwxQlcpqP9caAvQzeqbCMYZMXib3TRi9ocUi4iEUiqQKHPynBbUhFQZGV409mw5yBf1cU6zadgXuADifB0kLoMgdB04t89/1O/w1cDnyilFU=",
                "cache-control: no-cache",
                "content-type: application/json; charset=UTF-8",
            ),
        ));
            $response = curl_exec($curl);
            $error = curl_error($curl);
            curl_close($curl);
        }
        // Update a new stage for patients
        DB::table('patients')->where('arrive_date_time', '<=', Carbon::now()->subDays(90))->where('stage_id', $stayTwoMonthsStage->id)->update(['stage_id' => $stayThreeMonthsStage->id, 'admission_date_three_months' => today(), 'end_service_at' => now()]);
    }
}
