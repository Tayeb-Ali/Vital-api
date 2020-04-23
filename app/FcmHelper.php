<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\FcmHelper
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FcmHelper newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FcmHelper newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FcmHelper query()
 * @mixin \Eloquent
 */
class FcmHelper extends Model
{
    /**
     * Sending Message From FCM For Android
     * @param $data
     * @return bool|string
     */
    function send_android_fcm($fcm_registration_id, $title, $message)
    {
        $registatoin_ids = [$fcm_registration_id];
        $message = ['title' => $title, 'body' => $message];
        //Google cloud messaging GCM-API url
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = ['registration_ids' => $registatoin_ids, 'data' => ['message' => $message]];

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

    function send_android_fcm_all($registatoin_ids, $title, $message)
    {
        $message = ['title' => $title, 'body' => $message];
        //Google cloud messaging GCM-API url
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = ['registration_ids' => $registatoin_ids, 'data' => ['message' => $message]];

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

