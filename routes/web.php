<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return 'DetaTech ( 1.1.3) api V 2';
});

$router->get('profile/{id}', 'ProfileApiController@index');
//$router->post('update_profile/{id}', 'ProfileApiController');
$router->post('update_profile/{id}', 'ProfileApiController@uploadCvFileWeb');
$router->post('fcm_test', function (\Illuminate\Http\Request $request){
    $fcmHelper = new \App\FcmHelper();
    $fcmId = "c9MA5IWqsxI:APA91bEyRA1WhlGTL6QRS3Wc4DWut9c6ciarf0iodlAAi2K8reGZKzUF7sXTvtKEPEb30atj1P3_Rl2OlbnnH6E18NR0lUkkU0VBk-AgXsoel25pN8HrLQt_zjuWW3IGkHoTpfGahkyO";
    return $fcmHelper->send_android_fcm_all($fcmId, $request->title, $request->message, 1);

});
