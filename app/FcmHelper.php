<?php

namespace App;

use Eloquent;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

/**
 * App\FcmHelper
 *
 * @method static Builder|FcmHelper newModelQuery()
 * @method static Builder|FcmHelper newQuery()
 * @method static Builder|FcmHelper query()
 * @mixin Eloquent
 */

define("GOOGLE_API_KEY", env('FCM_SERVER_KEY'));
define("FCM_URL", 'https://fcm.googleapis.com/fcm/send');

class FcmHelper extends Model
{
    /**
     * Sending Message From FCM For Android
     * @param $fcm_registration_id
     * @param $title
     * @param $message
     * @param null $resultData
     * @param null $status
     * @return bool|string
     */
    function send_android_fcm($fcm_registration_id, $title, $message, $resultData = null, $status = null)
    {
        $fields = array(
            'notification' =>
                array(
                    'title' => $title,
                    'body' => $message,
                    'sound' => 'default',
                    'click_action' => 'FCM_PLUGIN_ACTIVITY',
                ),
            'data' =>
                array(
                    'requestId' => $resultData->id,
                    'status' => $status,
                    'latitude' => $resultData->latitude,
                    'longitude' => $resultData->longitude,
                ),
            'registration_ids' => $fcm_registration_id,

        );
        return $this->send_message($fields);
    }

    function send_android_fcm_all($registatoin_ids, $title, $message, $request = null, $status = null)
    {
        $fields = array(
            'notification' =>
                array(
                    'title' => $title,
                    'body' => $message,
                    'sound' => 'default',
                    'click_action' => 'FCM_PLUGIN_ACTIVITY',
                ),
            'data' =>
                array(
                    'requestId' => $request->id,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'status' => $status,
                ),
            'registration_ids' => $registatoin_ids,

        );

        return $this->send_message($fields);

    }

    /**
     * @param $topic
     * @param $title
     * @param $message
     * @param null $requestId
     * @return array|bool|string
     */
    function send_android_fcm_topic($topic, $title, $message, $requestId = null)
    {
        $fields = array(
            'notification' =>
                array(
                    'title' => $title,
                    'body' => $message,
                    'sound' => 'default',
                    'click_action' => 'FCM_PLUGIN_ACTIVITY',
                ),
            'data' =>
                array(
                    'requestId' => $requestId,
                ),
            'to' => "/topics/$topic",

        );

        return $this->send_message($fields);
    }

    function send_message_fcm($fcm_registration_id, $title, $message, $resultData = null)
    {
        $fields = array(
            'notification' =>
                array(
                    'title' => $title,
                    'body' => $message,
                    'sound' => 'default',
                    'click_action' => 'FCM_PLUGIN_ACTIVITY',
                ),
            'data' =>
                array(
                    'pharmacyId' => $resultData,
                ),
            'registration_ids' => $fcm_registration_id,

        );
        //Google cloud messaging GCM-API url
        $url = 'https://fcm.googleapis.com/fcm/send';
//       return $fields;

        // Update your Google Cloud Messaging API Key
        define("GOOGLE_API_KEY", env('FCM_SERVER_KEY'));

        $headers = [
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }

    private function send_message($fields)
    {
        $fields = json_encode ( $fields );

        $headers = [
            'Authorization' => "key=" . GOOGLE_API_KEY,
            'Content-Type' => 'application/json'
        ];

        $client = new Client();
        try {
            $request = $client->post(FCM_URL, [
                'headers' => $headers,
                "body" => $fields,
            ]);
            $response = $request->getBody();
            return $response;
        } catch (Exception $e) {
            return $e;
        }
    }

}

