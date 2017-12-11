<?php

Route::get('pos/stock/get', 'Stock\StockTableController')->name('stock.get');

Route::resource('pos/stock', 'Stock\StockController');



