<?php

Auth::routes();

Route::get('/', 'HomeController@index');

Route::get('home', 'HomeController@home')->middleware(['auth']);

Route::get('campaigns', 'CampaignController@index');

Route::get('campaign/create', 'CampaignController@create');

Route::get('invite/{campaign}/{user}', 'CampaignController@invite');

Route::get('offer/{campaign}/{user}', 'CampaignController@offer');

Route::post('apply', 'CampaignController@apply');

Route::post('comment', 'UserController@comment');

Route::post('campaign/store', 'CampaignController@store');

Route::post('campaign/{id}/uploads', 'CampaignController@uploads');

Route::resource('user', 'UserController');

Route::resource('user.info', 'InfoController', ['only' => [
	'update'
]]);

Route::resource('user.social', 'SocialController', ['only' => [
	'update', 'store'
]]);

Route::resource('user.site', 'SiteController', ['only' => [
	'update', 'store'
]]);

Route::resource('user.campaign', 'CampaignController');
