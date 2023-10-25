<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Patient;

class PatientAdventDelay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:patient-advent-delay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'patient-advent-delay';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $patientDecidedAdmitStage = DB::table('stages')->where('step', 4)->first();
        $patients = Patient::where('stage_id', $patientDecidedAdmitStage->id)->where('staying_decision', 'stay')->where('expected_arrive_date_time', '<', Carbon::today())->get();
        $token = 'TjgtSecwxe5X44lQ0JVaa8v4pJfAzMmsGhzWShRUNYU';
        foreach ($patients as $patient) {
            $numberDalayDay  = Carbon::parse($patient->expected_arrive_date_time)->diffInDays(date('Y-m-d'))+1;
            $messageToNotify = __('A patient named').' '. $patient->fullname .' '.__('Refer number').' '.$patient->number.' '.__('Referred by').' '.__($patient->referred_by->role).' '.$patient->referred_by->fullname.' '.__('has already been scheduled').' '.__('View more information here') .' '. url('/patients/'.$patient->id.'').'';
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, "https://notify-api.line.me/api/notify");
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, "message=" . $messageToNotify);
            $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $token . '',);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($curl);
            if (curl_error($curl)) {
                echo 'error:' . curl_error($curl);
            } else {
                $res = json_decode($result, true);
                echo "status : " . $res['status'];
                echo "message : " . $res['message'];
            }
            curl_close($curl);

            // Send message to Refferd person
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
                    "altText": "'.__('Informing patient advent delay') .' '.$patient->full_name.'",
                    "contents": {
                        "type": "bubble",
                        "body": {
                          "type": "box",
                          "layout": "vertical",
                          "contents": [
                            {
                              "type": "text",
                              "text": "'.__('Informing patient advent delay').'",
                              "weight": "bold",
                              "color": "#1DB446",
                              "size": "sm"
                            },
                            {
                              "type": "text",
                              "text": "'.__('Dear Khun') .' '.$patient->referred_by->full_name.'",
                              "size": "xs",
                              "color": "#aaaaaa",
                              "wrap": true
                            },
                            {
                              "type": "text",
                              "text": "'.__('Chivacare') .' '.__('would like to inform that') .' '.__('The patient you referred named') .' '.$patient->full_name .' '.__('has already been scheduled') .' '.$numberDalayDay .' '.__('day(s)').'",
                              "size": "xs",
                              "color": "#aaaaaa",
                              "wrap": true,
                              "margin": "lg"
                            },
                            {
                              "type": "text",
                              "text": "จึงเรียนมาเพื่อทราบ",
                              "size": "xs",
                              "color": "#aaaaaa",
                              "wrap": true,
                              "margin": "lg"
                            },
                            {
                                "type": "text",
                                "text": "'.__('If you have any questions or want to ask for more information. You can inquire through this chat').'",
                                "size": "xxs",
                                "color": "#aaaaaa",
                                "wrap": true,
                                "margin": "lg"
                            }
                          ]
                        },
                        "styles": {
                          "footer": {
                            "separator": true
                          }
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
