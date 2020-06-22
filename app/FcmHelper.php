<?php

namespace App;

use Eloquent;
use Exception;
use GuzzleHttp\Client;
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

    /**
     * Sending Message From FCM For Android
     * @param $fcm_registration_id
     * @param $title
     * @param $message
     * @param null $status
     * @return bool|string
     */
    function send_normal_fcm($fcm_registration_id, $title, $message, $status = null)
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
                    'status' => $status,
                ),
            'registration_ids' => $fcm_registration_id,

        );
        return $this->send_message($fields);
    }


    /**
     * @param $topic
     * @param $title
     * @param $message
     * @param null $image
     * @return array|bool|string
     */
    function send_fcm_topic($topic, $title, $message, $image = null)
    {
        $fields = array(
            'notification' =>
                array(
                    'title' => $title,
                    'body' => $message,
                    'sound' => 'default',
                    'image' => $image,
                    'click_action' => 'FCM_PLUGIN_ACTIVITY',
                ),
            'to' => "/topics/$topic",

        );

        return $this->send_message($fields);
    }


    /**
     * @param $topic
     * @param $title
     * @param $message
     * @param null $request
     * @return array|bool|string
     */
    function send_fcm_topic_requests($topic, $title, $message, $request = null)
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
                    'status' => 1,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                ),
            'to' => "/topics/$topic",

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
    function send_fcm_topic_emergency($topic, $title, $message, $requestId = null)
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
                    'status' => 2,
                ),
            'to' => "/topics/$topic",

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
    function send_fcm_topic_pharmacy($topic, $title, $message, $requestId = null)
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
                    'status' => 3,
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
                    'status' => 3,
                ),
            'registration_ids' => $fcm_registration_id,

        );

        return $this->send_message($fields);
    }

    // send Fcm function
    private function send_message($fields)
    {
        $fields = json_encode($fields);

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

