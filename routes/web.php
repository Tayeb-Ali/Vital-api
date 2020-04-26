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
