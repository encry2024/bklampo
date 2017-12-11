<?php


Route::group(['namespace' => 'Category'], function(){

	Route::resource('category', 'CategoryController');

});