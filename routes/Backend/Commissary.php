<?php

Route::group(['prefix' => 'commissary', 'namespace' => 'Commissary', 'as' => 'commissary.'], function(){

	Route::group(['namespace' => 'Inventory'], function(){

		Route::get('inventory/get', 'InventoryTableController')->name('inventory.get');

		Route::resource('inventory', 'InventoryController');

	});



	Route::group(['namespace' => 'Product'], function(){

		Route::get('product/get', 'ProductTableController')->name('product.get');

		Route::resource('product', 'ProductController');

	});



	Route::group(['namespace' => 'Stock'], function(){

		Route::get('stock/get', 'StockTableController')->name('stock.get');

		Route::resource('stock', 'StockController');

	});


	Route::group(['namespace' => 'produce'], function() {

		Route::get('produce/get', 'ProduceTableController')->name('produce.get');

		Route::resource('produce', 'ProduceController');

	});


	Route::group(['namespace' => 'Dispose'], function(){

		Route::get('dispose/get', 'DisposeTableController')->name('dispose.get');

		Route::resource('dispose', 'DisposeController');

	});


	Route::group(['namespace' => 'GoodsReturn'], function(){

		Route::get('goods_return/get', 'GoodsReturnTableController')->name('goods_return.get');

		Route::resource('goods_return', 'GoodsReturnController');

	});

	Route::group(['namespace' => 'Delivery'], function(){

		Route::get('delivery/get', 'DeliveryTableController')->name('delivery.get');

		Route::resource('delivery', 'DeliveryController');

	});


	Route::group(['namespace' => 'Invoice'], function(){

		Route::resource('invoice', 'InvoiceController');

	});

	Route::group(['namespace' => 'OrderForm'], function(){

		Route::resource('order_form', 'OrderFormController');

	});

});