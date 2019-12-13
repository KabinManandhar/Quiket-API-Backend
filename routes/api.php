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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//})
//Route::apiResource('/events','EventController');
Route::apiResource('/users','UserController')->middleware("auth:user");
Route::apiResource('/organizers','OrganizerController')->middleware("auth:organizer");
Route::group(['prefix'=>'organize;rs'],function(){
    Route::apiResource('/{organizer}/events','EventController');
    Route::group(['prefix'=>'events'],function(){
        Route::apiResource('/{event}/tickets','TicketController');
    });
});
//Route::get('organizers','OrganizerController@index');
//Route::get('organizers/{organizer}','OrganizerController@show');
