<?php

Route::group(['namespace' => 'Inventory'], function(){

	Route::get('pos/inventory/get', 'InventoryTableController')->name('inventory.get');

	Route::resource('pos/inventory', 'InventoryController');


});

