<?php
//Requires authentication
Route::middleware('auth:api')->group(function () {
	Route::prefix('user')->group(function () {
		Route::get('/', 'UsersController@index');
		Route::post('/profile', 'UsersController@show');
		Route::post('/create', 'UsersController@store');
		Route::get('/{id}/profile', 'UsersController@userById');
		Route::get('/{id}/tickets', 'UsersController@tickets');
	});

	Route::prefix('ticket')->group(function () {
		Route::get('/', 'TicketsController@index');
		Route::get('/{id}', 'TicketsController@show');
		Route::get('/{id}/consumer', 'TicketsController@consumer');
		Route::get('/{id}/collaborators', 'TicketsController@collaborators');
		Route::patch('/{id}/update', 'TicketsController@update');
		Route::post('/create', 'TicketsController@store');
	});

	Route::prefix('group')->group(function () {
		Route::get('/', 'GroupsController@index');
		Route::get('/users', 'GroupsController@users');
		Route::post('/create', 'GroupsController@create');
	});

	Route::get('/consumer-mails', 'ConsumersController@consumerEmails');
	Route::prefix('consumer')->group(function () {
		Route::get('/{id}', 'ConsumersController@show');
		Route::get('/{id}/tickets', 'ConsumersController@tickets');
		Route::get('/', 'ConsumersController@index');
		Route::patch('/{id}/update', 'ConsumersController@update');
	});
});