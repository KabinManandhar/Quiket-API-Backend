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
Route::post('organizer/logout/{organizer}','OrganizerController@logout')->name('organizer.logout')->middleware('auth:organizer');;
Route::post('user/logout/{user}','UserController@logout')->name('user.logout')->middleware('auth:user');;

//View All
Route::get('/events','EventController@index')->name('event.index');

//Views(Without Auth)
Route::get('/events/{event}','EventController@show')->name('event.show');
Route::get('/tickets/{ticket}','TicketController@show')->name('ticket.show');
Route::get('/organizers/{organizer}','OrganizerController@show')->name('organizer.show');
Route::get('/users/{user}','UserController@show')->name('user.show');

Route::get('/events/{event}/tickets','TicketController@showEventTicket')->name('event.showTicket');
Route::get('/{organizer}/events','EventController@showOrganizerEvent')->name('event.showOrganizerEvent');//Show organizer's event


//For Organizer
Route::put('/organizers/{organizer}', 'OrganizerController@update')->name('organizers.update')->middleware('auth:organizer');//Update Organizer Data
Route::put('/organizers/{organizer}/events/{event}', 'EventController@update')->name('events.update')->middleware('auth:organizer');//Update Event Data
Route::delete('/organizers/{organizer}', 'OrganizerController@destroy')->name('organizers.delete')->middleware('auth:organizer');//Delete Organizer Data);
Route::post('/organizers/events','EventController@store')->name('event.store')->middleware('auth:organizer');
Route::put('orders/{order}','OrderController@update')->name('order.update')->middleware('auth:organizer');
Route::post('/organizers/events/tickets','TicketController@store')->name('ticket.store')->middleware('auth:organizer');
Route::put('/organizers/{organizer}/tickets/{ticket}','TicketController@update')->name('ticket.update')->middleware('auth:organizer');
Route::delete('/organizers/{organizer}/events/{event}','EventController@destroy')->name('organizer.event.delete')->middleware('auth:organizer');
Route::delete('/organizers/{organizer}/tickets/{ticket}','TicketController@destroy')->name('organizer.event.ticket.delete')->middleware('auth:organizer');
Route::get('/events/{event}/orders','OrderController@showEventOrder')->name('orderEvent.show')->middleware('auth:organizer');
Route::get('/events/{event}/ordersCount','OrderController@showEventOrderCount')->name('orderEventCount.show')->middleware('auth:organizer');
Route::get('/orders/{order}','OrderController@show')->name('order.show')->middleware('auth:organizer');
Route::post('/orders/check','OrderController@qrChecker')->name('order.qrChecker')->middleware('auth:organizer');

//For User
Route::put('/users/{user}', 'UserController@update')->name('users.update')->middleware('auth:user');//Update User Data
Route::post('/users/{user}/bookmark','BookmarkController@store')->name('order.store')->middleware('auth:user');
Route::post('/users/{user}/bookmarkCheck','BookmarkController@checkBookmark')->name('checkBookmark.check')->middleware('auth:user');
Route::get('/users/{user}/bookmark','BookmarkController@getUserBookmark')->name('user.bookmark');
Route::post('/users/{user}/orders','OrderController@store')->name('order.store')->middleware('auth:user');
Route::get('/users/{user}/orders','OrderController@showUserOrder')->name('order.showUserOrder')->middleware('auth:user');
Route::get('/users/orders/{order}','OrderController@showUserTicket')->name('order.showUserTicket')->middleware('auth:user');
Route::delete('users/{user}/{order}','OrderController@destroy')->name('order.delete')->middleware('auth:user');
Route::post('bookmark/delete','BookmarkController@destroyId')->name('bookmark.delete')->middleware('auth:user');






