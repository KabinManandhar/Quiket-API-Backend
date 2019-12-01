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
Route::apiResource('/events','EventController');
Route::apiResource('/users','UserController')->middleware("auth:api");
Route::apiResource('/organizers','OrganizerController')->middleware("auth:organizer");
Route::group(['prefix'=>'organizers'],function(){
    Route::apiResource('/{organizer}/events','EventController');
    Route::group(['prefix'=>'eveents'],function(){
        Route::apiResource('/{event}/tickets','TicketController');
    });
});
