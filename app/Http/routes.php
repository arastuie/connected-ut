<?php

Route::get('/', 'WelcomeController@index');
Route::get('home', 'HomeController@index');

//Route::get('books', 'BooksController@index');
//Route::get('books/create', 'BooksController@create');
//Route::post('books/store', 'BooksController@store');
//Route::get('books/{books}/edit', 'BooksController@edit')->where('id', '[0-9]+');
//Route::patch('books/update', 'BooksController@update');

//Route::resource('books', 'BooksController');

Route::group(['prefix' => 'books', 'as' => 'books.'], function(){
    Route::get('/', ['as' => 'index', 'uses' => 'BooksController@index']);
    Route::get('/create', ['as' => 'create', 'uses' => 'BooksController@create']);
    Route::post('/store', ['as' => 'store', 'uses' => 'BooksController@store']);
    Route::get('/{books}/edit', ['as' => 'edit', 'uses' => 'BooksController@edit'])->where('books', '[0-9]+');
    Route::put('/{books}/update', ['as' => 'update', 'uses' => 'BooksController@update'])->where('books', '[0-9]+');
    Route::get('/{books}/sold/{sold}', ['as' => 'sold/delete', 'uses' => 'BooksController@destroy'])->where(['books' => '[0-9]+', 'sold' => 'true|false']);
    Route::get('/{books}', ['as' => 'show', 'uses' => 'BooksController@show'])->where('books', '[0-9]+');

});

Route::group(['prefix' => 'account', 'as' => 'accounts.'], function(){
    Route::get('/', ['as' => 'index', 'uses' => 'UsersController@index']);
    Route::get('/mybooks', ['as' => 'mybooks', 'uses' => 'UsersController@my_books']);
    Route::get('change_password', ['as' => 'change_password', 'uses' => 'UsersController@change_password']);
    Route::patch('change_password', ['as' => 'update_password', 'uses' => 'UsersController@update_password']);
    Route::get('update', ['as' => 'update', 'uses' => 'UsersController@update']);
});

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);