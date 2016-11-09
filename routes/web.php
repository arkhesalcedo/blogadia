<?php

Auth::routes();

Route::get('/', 'HomeController@index');

Route::get('home', 'HomeController@home')->middleware(['auth']);

Route::resource('user.info', 'InfoController', ['only' => [
	'update'
]]);

Route::resource('user.social', 'SocialController', ['only' => [
	'update', 'store'
]]);

Route::resource('user.site', 'SiteController', ['only' => [
	'update', 'store'
]]);

Route::resource('user', 'UserController');
