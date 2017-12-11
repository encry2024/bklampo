<?php 
	
	Route::group(['namespace' => 'Request'], function() 
		{

			Route::get('request/get', 'RequestTableController')->name('request.get');

			Route::resource('request', 'RequestController');

		}
	);