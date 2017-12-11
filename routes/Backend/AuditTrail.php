<?php

Route::group(['namespace' => 'AuditTrail', 'prefix' => 'audit_trail', 'as' => 'audit_trail.'], function(){

	Route::get('/get', 'AuditTrailTableController')->name('get');

	Route::resource('/', 'AuditTrailController');


});

