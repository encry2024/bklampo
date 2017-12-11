<?php

/**
 * All route names are prefixed with 'admin.'.
 */
Route::get('dashboard', 'DashboardController@index')->name('dashboard');

Route::get('dashboard/request_all', 'DashboardController@getAllRequest');

Route::get('dashboard/request/{id}', 'DashboardController@getRequest');

Route::post('dashboard/response', 'DashboardController@storeResponse');
