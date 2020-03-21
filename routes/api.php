<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Views(Without Auth)
Route::get('/events/{event}','EventController@show')->name('event.show');
Route::get('/tickets/{ticket}','TicketController@show')->name('ticket.show');
Route::get('/organizers/{organizer}','OrganizerController@show')->name('organizer.show');
Route::get('/events/{event}/ticket','EventController@showTicket')->name('event.showTicket');
Route::get('/{organizer}/events','EventController@showOrganizerEvent')->name('event.showOrganizerEvent');//Show organizer's event


//For Organizer
Route::put('/organizers/{organizer}', 'OrganizerController@update')->name('organizers.update')->middleware('auth:organizer');//Update Organizer Data
Route::put('/organizers/{organizer}/{event}', 'EventController@update')->name('events.update')->middleware('auth:organizer');//Update Event Data
Route::delete('/organizers/{organizer}', 'OrganizerController@destroy')->name('organizers.delete')->middleware('auth:organizer');//Delete Organizer Data);
Route::post('/organizers/event','EventController@store')->name('event.store')->middleware('auth:organizer');
Route::post('/organizers/event/ticket','TicketController@store')->name('ticket.store')->middleware('auth:organizer');
Route::put('/organizers/{organizer}/events/{event}/tickets/{ticket}','TicketController@update')->name('ticket.update')->middleware('auth:organizer');
Route::delete('/organizers/{organizer}/events/{event}','EventController@destroy')->name('organizer.event.delete')->middleware('auth:organizer');
Route::delete('/organizers/{organizer}/events/{event}/tickets/{ticket}','TicketController@destroy')->name('organizer.event.ticket.delete')->middleware('auth:organizer');

//For User
Route::post('/user/{user}/bookmark','BookmarkController@store')->name('order.store')->middleware('auth:user');
Route::post('/user/{user}/order','OrderController@store')->name('order.store')->middleware('auth:user');
Route::delete('user/{user}/{order}','OrderController@destroy')->name('order.delete')->middleware('auth:user');
Route::delete('user/{user}/{bookmark}','BookmarkController@destroy')->name('order.delete')->middleware('auth:user');






