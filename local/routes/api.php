<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('get_access',function(Request $request){

    $http = new GuzzleHttp\Client;

    $response = $http->post(url('oauth/token'), [
        'form_params' => [
            'grant_type'=>'client_credentials',
            'client_id' => $request->get('client_id'),
            'client_secret' => $request->get('client_secret'),
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});

Route::post('authentication',function(Request $request){
    $http = new GuzzleHttp\Client;

    $response = $http->post(url('oauth/token'), [
        'form_params' => [
            'grant_type' => 'password',
            'client_id' => $request->get('client_id'),
            'client_secret' => $request->get('client_secret'),
            'username' => $request->get('username'),
            'password' => $request->get('password'),
            'scope' => '',
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});

Route::post('refresh_token',function(Request $request){
    $http = new GuzzleHttp\Client;

    $response = $http->post(url('oauth/token'), [
        'form_params' => [
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->get('refresh_token'),
            'client_id' => $request->get('client_id'),
            'client_secret' => $request->get('client_secret'),
            'scope' => '',
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});


Route::group(['namespace'=>'Api'],function() {
    Route::group(['middleware' => 'auth:api'], function () {

    });

    Route::group(['middleware'=>'client_credentials'],function(){

    });
});
