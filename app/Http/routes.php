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

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');


//Route::get('books', 'BooksController@index');
//Route::get('books/create', 'BooksController@create');
//Route::post('books/store', 'BooksController@store');
//Route::get('books/{books}/edit', 'BooksController@edit')->where('id', '[0-9]+');
//Route::patch('books/update', 'BooksController@update');

Route::resource('books', 'BooksController');



Route::group(['prefix' => 'account', 'as' => 'Account.'], function(){

    Route::get('/', ['uses' => 'UsersController@index']);
    Route::get('change_password', ['uses' => 'UsersController@change_password']);
    Route::patch('change_password', ['uses' => 'UsersController@update_password']);
    Route::get('update', ['uses' => 'UsersController@update']);

});



Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
