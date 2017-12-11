<?php

Route::group(['namespace' => 'Report', 'prefix' => 'report', 'as' => 'report.'], function(){

	Route::group(['prefix' => 'pos', 'as' => 'pos.', 'namespace' => 'POS'], function(){

		Route::group([
			'prefix' 	=> 'daily', 
			'as' 		=> 'daily.'], function() {

				Route::resource('/', 'DailyController');

		});

		Route::group([
			'prefix' 	=> 'monthly', 
			'as' 		=> 'monthly.'], function() {

				Route::resource('/', 'MonthlyController');

		});

		Route::group(['prefix' => 'sale', 'as' => 'sale.'], function() {

			Route::get('get', 'ReportTableController')->name('get');

			Route::get('/', 'ReportController@index')->name('index');

			Route::get('sale/{id}', 'ReportController@show')->name('show');

			Route::delete('sale/{id}', 'ReportController@destroy')->name('destroy');

		});

	});


	Route::group(['prefix' => 'commissary', 'as' => 'commissary.', 'namespace' => 'Commissary'], function(){
		
		Route::group([
			'prefix' => 'daily', 
			'as' => 'daily.'], function() {

				Route::group(['prefix' => 'inventory', 'as' => 'inventory.', 'namespace' => 'Inventory'], function() {

					Route::resource('/', 'ReportController');

				});

				Route::group(['prefix' => 'delivery', 'as' => 'delivery.', 'namespace' => 'Delivery'], function() {

					Route::resource('/', 'ReportController');

				});

				Route::group(['prefix' => 'sale', 'as' => 'sale.', 'namespace' => 'Sale'], function(){

					Route::resource('/', 'ReportController');

				});
		});


		Route::group(['prefix' => 'disposal', 'as' => 'disposal.', 'namespace' => 'Disposal'], function(){

			Route::resource('/', 'ReportController');

		});

		Route::group(['prefix' => 'goods_return', 'as' => 'goods_return.', 'namespace' => 'GoodsReturn'], function(){

			Route::resource('/', 'ReportController');

		});


		Route::group(['prefix' => 'summary', 'as' => 'summary.', 'namespace' => 'Summary'], function(){

			Route::resource('/', 'ReportController');

		});


	});
	
	
});


