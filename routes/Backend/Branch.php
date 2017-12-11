<?php


Route::group(['namespace' => 'Branch'], function(){

	Route::get('branch/get', 'BranchTableController')->name('branch.get');

	Route::resource('branch', 'BranchController');

});