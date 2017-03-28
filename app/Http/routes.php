<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'SiteController@index');

Route::auth();

Route::get('admin', 'AdminController@login');
Route::post('admin/loginme', 'AdminController@loginme');

//TODO Middlewares after
	Route::get('admin/logout', 'AdminController@logout');
	Route::get('admin/users', 'AdminController@index');
	Route::get('admin/customers', 'AdminController@customers');
	Route::get('admin/experts/{id?}', ['uses' =>'AdminController@experts']);
	Route::post('admin/suspend', 'AdminController@suspend');
	Route::post('admin/active', 'AdminController@active');
	Route::post('admin/delete-user', 'AdminController@delete_user');
	Route::post('admin/search-user', 'AdminController@search_user');
	Route::post('admin/add-category', 'AdminController@add_category');
	Route::post('admin/save-category', 'AdminController@save_category');
	Route::get('admin/delete-category/{id}', 'AdminController@delete_category');

	Route::get('admin/statistics', 'AdminController@statistics');
	Route::post('admin/statistics', 'AdminController@statistics');