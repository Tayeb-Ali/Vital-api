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

$router->group(['prefix' => 'api'], function () use ($router) {

    $router->group(['prefix' => 'auth'], function () use ($router) {
        $router->post('login', 'AuthControllerApi@login');
        $router->post('register', 'AuthControllerApi@register');

        $router->post('logout', 'AuthControllerApi@logout');
        $router->post('fcm_update', 'ProfileApiController@updateFCM');
        $router->get('check_user', 'ProfileApiController@checkUser');
    });

    $router->post('upload_image', 'ProfileApiController@uploadImage');
    $router->post('upload_cv', 'ProfileApiController@uploadCvFile');

    $router->get('medical_fields', 'MedicalFieldAPIController@index');
    $router->get('medical_fields/{id}', 'MedicalFieldAPIController@show');


    $router->get('medical_specialties', 'MedicalSpecialtyAPIController@index');
    $router->get('medical_specialties/{id}', 'MedicalSpecialtyAPIController@show');

//
    $router->get('employs', 'EmployAPIController@index');
    $router->get('employs/{id}', 'EmployAPIController@show');
    $router->delete('employs/{id}', 'EmployAPIController@destroy');
    $router->post('employs', 'EmployAPIController@store');
    $router->put('employs/{id}', 'EmployAPIController@update');

//
    $router->get('accept_request_specialists', 'AcceptRequestSpecialistsAPIController@index');
    $router->get('accept_request_specialists/{id}', 'AcceptRequestSpecialistsAPIController@show');
    $router->delete('accept_request_specialists/{id}', 'AcceptRequestSpecialistsAPIController@destroy');
    $router->post('accept_request_specialists', 'AcceptRequestSpecialistsAPIController@store');
    $router->put('accept_request_specialists/{id}', 'AcceptRequestSpecialistsAPIController@update');


    $router->get('wallets', 'WalletAPIController@index');
    $router->get('wallets/{id}', 'WalletAPIController@show');
    $router->delete('wallets/{id}', 'WalletAPIController@destroy');
    $router->post('wallets', 'WalletAPIController@store');
    $router->put('wallets/{id}', 'WalletAPIController@update');

//
    $router->get('request_specialists', 'RequestSpecialistsAPIController@index');
    $router->get('request_specialists/{id}', 'RequestSpecialistsAPIController@show');
    $router->delete('request_specialists/{id}', 'RequestSpecialistsAPIController@destroy');
    $router->post('request_specialists', 'RequestSpecialistsAPIController@store');
    $router->put('request_specialists/{id}', 'RequestSpecialistsAPIController@update');
//
    $router->get('request_specialists_admin_history', 'RequestSpecialistsAPIController@adminHistory');
    $router->get('request_specialists_doctor_history', 'RequestSpecialistsAPIController@doctorHistory');
    $router->get('request_specialists_history', 'RequestSpecialistsAPIController@history');
    $router->get('search_request_specialists/{search}', 'RequestSpecialistsAPIController@search');
//
    $router->get('acceptRequestByAdmin/{id}', 'AcceptRequestSpecialistsAPIController@acceptRequestByAdmin');
    $router->get('acceptRequestByUser/{id}', 'AcceptRequestSpecialistsAPIController@acceptRequestByUser');
    $router->get('cancelRequestByAdmin/{id}', 'AcceptRequestSpecialistsAPIController@cancelRequestByAdmin');
    $router->get('cancelRequestByUser/{id}', 'AcceptRequestSpecialistsAPIController@cancelRequestByUser');
    $router->post('acceptRequestAndDone/{id}', 'AcceptRequestSpecialistsAPIController@acceptRequestAndDone');
//
    $router->get('emergency_serviced', 'EmergencyServicedAPIController@index');
    $router->get('emergency_serviced/{id}', 'EmergencyServicedAPIController@show');
    $router->delete('emergency_serviced/{id}', 'EmergencyServicedAPIController@destroy');
    $router->post('emergency_serviced', 'EmergencyServicedAPIController@store');
    $router->put('emergency_serviced/{id}', 'EmergencyServicedAPIController@update');

    $router->get('emergency_serviced_admin_history', 'EmergencyServicedAPIController@adminHistory');
    $router->get('emergency_serviced_user_history', 'EmergencyServicedAPIController@userHistory');

//
    $router->get('ambulances', 'AmbulanceAPIController@index');
    $router->get('ambulances/{id}', 'AmbulanceAPIController@show');
    $router->delete('ambulances/{id}', 'AmbulanceAPIController@destroy');
    $router->post('ambulances', 'AmbulanceAPIController@store');
    $router->put('ambulances/{id}', 'AmbulanceAPIController@update');

//
    $router->get('pharmacies', 'PharmacyAPIController@index');
    $router->get('pharmacies/{id}', 'PharmacyAPIController@show');
    $router->delete('pharmacies/{id}', 'PharmacyAPIController@destroy');
    $router->post('pharmacies', 'PharmacyAPIController@store');
    $router->put('pharmacies/{id}', 'PharmacyAPIController@update');

    $router->get('pharmacy_by_user', 'PharmacyAPIController@showByUser');
    $router->get('pharmacy_by_pharmacy', 'PharmacyAPIController@showByPharmacy');
});
