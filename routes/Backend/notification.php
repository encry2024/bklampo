<?php

Route::group(['namespace' => 'Notification'], function(){

	Route::get('notification/read', 'NotificationController@readAll')->name('notification.read');

	Route::get('notification/get', 'NotificationTableController')->name('notification.get');

	Route::resource('notification', 'NotificationController');
});