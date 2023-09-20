<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Patient;

class PatientReferralCommissionTwoMonths extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:patient-referral-commission-two-months';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Report the commission for two months to the patient\'s referral';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $patients = Patient::where('arrive_date_time', '<=', Carbon::now()->subDays(60))->get();

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
                    "altText": "'.__('Referral fee').'",
                    "contents": {
                        "type": "bubble",
                        "body": {
                            "type": "box",
                            "layout": "vertical",
                            "contents": [
                                {
                                    "type": "text",
                                    "text": "Referral fee",
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
                                    "text": "'.__('Chivacare') .' '.__('congratulations') .' '.__('Because you receive referral fees') .' '.__('it is an amount of') .' '.__('2,000 Bath') .' '.__('from the patient you referred named') .' '.$patient->full_name .' '.__('whose has completed of stay for') .' '.__('60 Days') .' '.__('From the first day of stay') .' '.$patient->arrive_date_time.'",
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
                                },
                                {
                                    "type": "separator",
                                    "margin": "md"
                                },
                                {
                                    "type": "box",
                                    "layout": "vertical",
                                    "margin": "xxl",
                                    "spacing": "md",
                                    "contents": [
                                        {
                                            "type": "box",
                                            "layout": "horizontal",
                                            "contents": [
                                                {
                                                    "type": "text",
                                                    "text": "'.__('First month').'",
                                                    "size": "sm",
                                                    "color": "#555555",
                                                    "flex": 0
                                                },
                                                {
                                                    "type": "text",
                                                    "text": "฿1,000.00",
                                                    "size": "sm",
                                                    "color": "#111111",
                                                    "align": "end"
                                                }
                                            ]
                                        },
                                        {
                                            "type": "box",
                                            "layout": "horizontal",
                                            "contents": [
                                                {
                                                    "type": "text",
                                                    "text": "'.__('Month 2').'",
                                                    "size": "sm",
                                                    "color": "#555555",
                                                    "flex": 0
                                                },
                                                {
                                                    "type": "text",
                                                    "text": "฿1,000.00",
                                                    "size": "sm",
                                                    "color": "#111111",
                                                    "align": "end"
                                                }
                                            ]
                                        },
                                        {
                                            "type": "separator",
                                            "margin": "lg"
                                        },
                                        {
                                            "type": "box",
                                            "layout": "horizontal",
                                            "margin": "md",
                                            "contents": [
                                                {
                                                    "type": "text",
                                                    "text": "'.__('Total in money').'",
                                                    "size": "sm",
                                                    "color": "#555555"
                                                },
                                                {
                                                    "type": "text",
                                                    "text": "฿2,000.00",
                                                    "size": "sm",
                                                    "color": "#1DB446",
                                                    "align": "end",
                                                    "weight": "bold"
                                                }
                                            ]
                                        }
                                    ]
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
    }
}
