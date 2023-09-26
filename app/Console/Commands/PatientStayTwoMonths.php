<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Patient;

class PatientStayTwoMonths extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:patient-stay-two-months';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update patient stage if they stay for 60 day';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $stayOneMonthStage = DB::table('stages')->where('step', 6)->first();
        $stayTwoMonthsStage = DB::table('stages')->where('step', 7)->first();

        $patients = Patient::where('arrive_date_time', '<=', Carbon::now()->subDays(60))->where('stage_id', $stayOneMonthStage->id)->where('end_service_at', null)->get();

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
                                    "text": "'.$stayTwoMonthsStage->name.'",
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
            $err = curl_error($curl);
            curl_close($curl);
        }
        // Send the Patient referral fee
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
                    "altText": "'.__('Patient referral fee') .' '.$patient->full_name.'",
                    "contents": {
                        "type": "bubble",
                        "body": {
                            "type": "box",
                            "layout": "vertical",
                            "contents": [
                                {
                                    "type": "text",
                                    "text": "'.__('Patient referral fee') .' '.$patient->full_name.'",
                                    "weight": "bold",
                                    "color": "#1DB446",
                                    "size": "sm"
                                },
                                {
                                    "type": "text",
                                    "text": "'.__('Dear Khun') .' '.$patient->referred_by->full_name.'",
                                    "size": "sm",
                                    "color": "#aaaaaa",
                                    "wrap": true,
                                    "margin": "md"
                                },
                                {
                                    "type": "text",
                                    "text": "'.__('Chivacare') .' '.__('congratulations') .' '.__('Because you receive referral fees') .' '.__('it is an amount of') .' '.__('1,000 Bath') .' '.__('from the patient you referred named') .' '.$patient->full_name .' '.__('which has been in service for') .' '.__('2') .' '.__('months') .' '.__('From the first day of stay') .' '.date('Y-m-d', strtotime($patient->arrive_date_time)).'",
                                    "size": "sm",
                                    "color": "#aaaaaa",
                                    "wrap": true,
                                    "margin": "md"
                                },
                                {
                                    "type": "text",
                                    "text": "'.__('Forwarded for your information').'",
                                    "size": "sm",
                                    "color": "#aaaaaa",
                                    "wrap": true,
                                    "margin": "md"
                                }
                            ]
                        },
                        "footer": {
                            "type": "box",
                            "layout": "horizontal",
                            "contents": [
                                {
                                    "type": "text",
                                    "text": "'.__('Note: This is just a notification message in the system. The payment account will inform you of the slip again').'",
                                    "size": "xxs",
                                    "wrap": true,
                                    "color": "#aaaaaa",
                                    "margin": "5px"
                                }
                            ],
                            "margin": "md"
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

        DB::table('patients')->where('end_service_at', null)->where('arrive_date_time', '<=', Carbon::now()->subDays(60))->where('stage_id', $stayOneMonthStage->id)->update(['stage_id' => $stayTwoMonthsStage->id, 'admission_date_two_months' => today()]);
    }
}
