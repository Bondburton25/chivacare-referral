<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    function pushFlexMessage($encodeJson) {
        $datasReturn = [];
        $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://api.line.me/v2/bot/message/push",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => $encodeJson,
              CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.config('settings.channelAccessToken').'',
                'cache-control: no-cache',
                'content-type: application/json; charset=UTF-8',
              ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                $datasReturn['result'] = 'Error';
                $datasReturn['message'] = $err;
            } else {
                if($response == "{}"){
                    $datasReturn['result'] = 'Status';
                    $datasReturn['message'] = 'Success';
                } else {
                    $datasReturn['result'] = 'Error';
                    $datasReturn['message'] = $response;
                }
            }
            return $datasReturn;
        }

    public function pushMessage($message, $type)
    {
        $ch = curl_init('https://api.line.me/v2/bot/message/'.$type);
        $payload = json_encode($message);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer '. config('settings.channelAccessToken') . '',)
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
    }

    public function lineNotify($messageToNotify, $token)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://notify-api.line.me/api/notify");
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "message=" . $messageToNotify);
        $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $token . '',);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        if (curl_error($ch)) {
            echo 'error:' . curl_error($ch);
        } else {
            $res = json_decode($result, true);
            echo "status : " . $res['status'];
            echo "message : " . $res['message'];
        }
        curl_close($ch);
    }
}
