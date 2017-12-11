<?php



Route::group(['namespace' => 'Product'], function(){

	Route::get('pos/product/get', 'ProductTableController')->name('product.get');

	Route::get('pos/product/unit_type/{id}', 'ProductController@unit_type')->name('product.unit_type');

	Route::resource('pos/product', 'ProductController');
});

