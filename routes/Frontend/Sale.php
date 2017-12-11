<?php

Route::group(['namespace' => 'Sale'], function(){

	Route::post('sale/save', 'SaleController@save')->name('sale.save');

	Route::get('sale/daily', 'SaleController@index')->name('sale.daily');

	Route::get('sale/monthly', 'SaleController@monthly')->name('sale.monthly');

});