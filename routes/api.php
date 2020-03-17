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

Route::post('/users','UserController@store')->name('users.register');
Route::post('/organizers','OrganizerController@store')->name('organizers.register');//Register Organizer
//For Organizer
Route::group(['prefix'=>'organizers','middleware'=>['auth:organizer'] ],function(){
    Route::get('/','OrganizerController@index')->name('organizers.index');//Get all Organizers
    Route::get('/{organizer}','OrganizerController@show')->name('organizers.show');//Get selected Organizer

    Route::put('/{organizer}','OrganizerController@update')->name('organizers.update');//Update Organizer Data
    Route::delete('/{organizer}','OrganizerController@destroy')->name('organizers.delete');//Delete Organizer Data
    Route::group(['prefix'=>'events'],function(){
        Route::apiResource('/{event}/tickets','TicketController');
    });});

//View All
Route::get('/','OrganizerController@index')->name('organizers.index')->middleware("auth:organizer");
Route::post('/login','OrganizerController@login')->name('organizers.login');
Route::post('/users','UserController@store')->name('users.register');
//Route::get('/organizers','OrganizerController@index');//Get all Organizers
//Route::get('/organizers/{organizer}','OrganizerController@show');//Get selected Organizer
//Route::post('/organizers','OrganizerController@store');//Register Organizer
//Route::put('/organizers/{organizer}','OrganizerController@update');//Update Organizer Data
//Route::delete('/organizers/{organizer}','OrganizerController@delete');//Delete Organizer Data
////Events by Organizer Controls
//Route::get('/{organizer}/events','EventController@showOrganizerEvent');//Get selected Organizer's Events
//Route::post('/events','EventController@store');//Create new Event of the Organizer
//Route::put('events/{event}','EventController@update');//Update Event Data
//Route::delete('events/{event}','EventController@delete');//Delete Event Data
//Route::post('/{organizer}/events/{event}/tickets','TicketController@store');//Create tickets for the Event
//Route::put('/{organizer}/event/{event}/tickets/{ticket}','TicketController@update');//Update Ticket Data
//Route::delete('/{organizer}/event/{event}/tickets/{ticket}','TicketController@delete');//Delete Ticket Data

//For User
//Route::get('/users','UserController@index');
//Route::get('/users/{user}','UserController@show');
//Route::post('/users','UserController@store');
//Route::put('/users/{user}','UserController@update');
//Route::delete('/users/{user}','UserController@delete');


//For Event
//Route::get('/events','EventController@index');
//Route::get('/events/{event}','EventController@show');
//Organizer



//For Tickets
//Route::get('/tickets','TicketController@index');
//Route::get('/events/{event}','TicketController@show');
//Organizer
//Route::post('/events','TicketController@store');
//Route::put('/events/{event}','TicketController@update');
//Route::delete('/events/{event}','TicketController@delete');
//
//For Order
//Route::get('/tickets','TicketController@index');
//Route::get('/events/{event}','TicketController@show');
//Organizer
//Route::post('/events','TicketController@store');
//Route::put('/events/{event}','TicketController@update');
//Route::delete('/events/{event}','TicketController@delete');



//
//For Bookmarks
//Route::get('/bookmarks','BookmarkController@index');-> not needed
//Route::get('/events/{event}','EventController@show');
//Route::post('/events','EventController@store');
//Route::put('/events/{event}','EventController@update');
//Route::delete('/events/{event}','EventController@delete');




