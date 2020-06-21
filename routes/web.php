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


//    $router->group(['prefix' => 'auth'], function () use ($router) {
//
//        $router->post('admin_login', 'AuthControllerApi@adminLogin');
//    });


$router->group(['prefix' => 'admin'], function () use ($router) {
    $router->get('dashboard', 'Web\DashboardWEBController@index');

    //blog
    $router->get('blog', 'Web\BlogWEBController@index');
    $router->post('blog', 'Web\BlogWEBController@store');
    $router->get('blog/create', 'Web\BlogWEBController@create');
    $router->get('blog/{id}/view', 'Web\BlogWEBController@show');
    $router->get('blog/{id}/edit', 'Web\BlogWEBController@edit');
    $router->put('blog/{id}/update', 'Web\BlogWEBController@update');
    $router->get('blog/{id}/delete', 'Web\BlogWEBController@destroy');
    //Users
    $router->get('users', 'Web\UserWEBController@index');
    $router->post('users', 'Web\UserWEBController@store');
    $router->get('users/create', 'Web\UserWEBController@create');
    $router->get('users/{id}/view', 'Web\UserWEBController@show');
    $router->get('users/{id}/edit', 'Web\UserWEBController@edit');
    $router->put('users/{id}/update', 'Web\UserWEBController@update');
    $router->get('users/{id}/delete', 'Web\UserWEBController@destroy');
    //MedicalField
    $router->get('MedicalField', 'Web\UserWEBController@index');
    $router->post('MedicalField', 'Web\UserWEBController@store');
    $router->get('MedicalField/create', 'Web\UserWEBController@create');
    $router->get('MedicalField/{id}/view', 'Web\UserWEBController@show');
    $router->get('MedicalField/{id}/edit', 'Web\UserWEBController@edit');
    $router->put('MedicalField/{id}/update', 'Web\UserWEBController@update');
    $router->get('MedicalField/{id}/delete', 'Web\UserWEBController@destroy');
    //medical_specialists
    $router->get('medical_specialists', 'Web\MedicalSpecialtyWEBController@index');
    $router->post('medical_specialists', 'Web\MedicalSpecialtyWEBController@store');
    $router->get('medical_specialists/create', 'Web\MedicalSpecialtyWEBController@create');
    $router->get('medical_specialists/{id}/view', 'Web\MedicalSpecialtyWEBController@show');
    $router->get('medical_specialists/{id}/edit', 'Web\MedicalSpecialtyWEBController@edit');
    $router->put('medical_specialists/{id}/update', 'Web\MedicalSpecialtyWEBController@update');
    $router->get('medical_specialists/{id}/delete', 'Web\MedicalSpecialtyWEBController@destroy');

});

$router->get('/', function () {
    return 'Hi pro';

});


$router->get('topic', function () {
    $dd = new \App\FcmHelper();
    return $dd->send_android_fcm_topic('doctor', 'welcome', 'wellcom in Hawjah app', 1);

});

//$router->get('request_test/{id}', function ($id) {
//    $fcm_user_id = [
//       ];
//    $dd = new \App\FcmHelper();
////    $data = [
////        'id' => 1,
////        'latitude' => 32.324124,
////        'longitude' => 15.312123
////    ];
//    $status =2;
//    return $dd->send_normal_fcm($fcm_user_id, 'welcome', 'wellcom in Hawjah app', $id);
//
//});

