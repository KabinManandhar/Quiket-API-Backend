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
//Route::apiResource('/events','EventController');//Api Based Permission with role
//Route::apiResource('/users','UserController')->middleware("auth:user");
//Route::apiResource('/organizers','OrganizerController')->middleware("auth:organizer");
//Route::group(['prefix'=>'organizers' ],function(){
//    Route::apiResource('/{organizer}/events','EventController');
//    Route::group(['prefix'=>'events'],function(){
//        Route::apiResource('/{event}/tickets','TicketController');
//    });});
//Credential Controls

//Register
Route::post('/user/register','UserController@store')->name('user.register');//user
Route::post('/organizer/register','OrganizerController@store')->name('organizer.register');//organizer

//Login
Route::post('/organizer/login','OrganizerController@login')->name('organizer.login');
Route::post('/user/login','UserController@login')->name('user.login');

//Logout
Route::post('/logout/{organizer}','OrganizerController@logout')->name('organizer.logout');
Route::post('/logout/{user}','UserController@logout')->name('user.logout');

//View All
Route::get('/events','EventController@index')->name('event.index');

//View Single(Without Auth)
Route::get('/events/{event}','EventController@show')->name('event.show');
Route::get('/tickets/{ticket}','TicketController@show')->name('ticket.show');
Route::get('/organizers/{organizer}','OrganizerController@show')->name('organizer.show');
Route::get('/events/ticket','EventController@showTicket')->name('event.showTicket');

//Posting by Organizer
Route::post('/{organizer}','OrganizerController@logout')->name('organizers.logout');

//For Organizer
Route::group(['prefix'=>'organizers','middleware'=>['auth:organizer'] ],function() {
    Route::put('/{organizer}', 'OrganizerController@update')->name('organizers.update');//Update Organizer Data
    Route::delete('/{organizer}', 'OrganizerController@destroy')->name('organizers.delete');//Delete Organizer Data);
});

//View All
Route::get('/','OrganizerController@index')->name('organizers.index')->middleware("auth:organizer");
Route::post('/login','OrganizerController@login')->name('organizers.login');
Route::post('/logout/{organizer}','OrganizerController@logout')->name('organizers.logout');






