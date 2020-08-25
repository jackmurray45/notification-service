<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['auth:api']], function(){
    Route::apiResource('tokens', 'TokenController');

    Route::prefix('tokens')->group(function(){
        Route::post('{token}/roles/{role}', 'TokenController@assignRole');
        Route::delete('{token}/roles/{role}', 'TokenController@removeRole');
        Route::post('{token}/generate_token', 'TokenController@generateNewToken');
    });
    
    Route::apiResource('notifications', 'NotificationController');
    Route::apiResource('roles', 'RoleController');
});



