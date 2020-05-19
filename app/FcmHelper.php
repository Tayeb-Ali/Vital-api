<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\FcmHelper
 *
 * @method static Builder|FcmHelper newModelQuery()
 * @method static Builder|FcmHelper newQuery()
 * @method static Builder|FcmHelper query()
 * @mixin Eloquent
 */
class FcmHelper extends Model
{
    /**
     * Sending Message From FCM For Android
     * @param $fcm_registration_id
     * @param $title
     * @param $message
     * @param null $resultData
     * @return bool|string
     */
    function send_android_fcm($fcm_registration_id, $title, $message, $resultData = null)
    {
//        $registatoin_ids = [$fcm_registration_id];
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
                    'latitude' => $resultData->latitude,
                    'longitude' => $resultData->longitude,
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

    function send_android_fcm_all($registatoin_ids, $title, $message, $request = null)
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
                ),
            'registration_ids' => $registatoin_ids,

        );

        // Update your Google Cloud Messaging API Key
        define("GOOGLE_API_KEY", env('FCM_SERVER_KEY'));

        //Google cloud messaging GCM-API url
        $url = 'https://fcm.googleapis.com/fcm/send';

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
        //Google cloud messaging GCM-API url
        $url = 'https://fcm.googleapis.com/fcm/send';
//        return $fields;

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

}

