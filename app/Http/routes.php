<?php

Route::get('/', function(){
    return view('index');
});

Route::get('/home', function(){
    return view('index');
});

// Login & register
Route::group(['prefix' => 'auth', 'as' => 'auth.'], function(){
    // Authentication routes...
    Route::get('login', ['as' => 'login.index', 'uses' => 'Auth\AuthController@getLogin']);
    Route::post('login', ['as' => 'login', 'uses' => 'Auth\AuthController@postLogin'])->before('csrf');
    Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);

    // Registration routes...
    Route::get('register', ['as' => 'register.index', 'uses' => 'Auth\RegistrationController@getRegister']);
    Route::post('register', ['as' => 'register', 'uses' => 'Auth\RegistrationController@postRegister'])->before('csrf');
    Route::put('register/confirm/resend', ['as' => 'register.resend.confirm', 'uses' => 'Auth\RegistrationController@resendConfirmEmail'])->before('csrf');
    Route::get('register/confirm/{token}', ['as' => 'register.confirm', 'uses' => 'Auth\RegistrationController@confirmEmail']);
    Route::get('register/disconfirm/{token}', ['as' => 'register.disconfirm', 'uses' => 'Auth\RegistrationController@disconfirmEmail']);
});

// Password reset
Route::group(['prefix' => 'password', 'as' => 'password_reset.'], function(){
    // Password reset link request routes...
    Route::get('email', ['as' => 'password.request.index', 'uses' => 'Auth\PasswordController@getEmail']);
    Route::post('email', ['as' => 'password.request', 'uses' => 'Auth\PasswordController@postEmail']);

    // Password reset routes...
    Route::get('reset/{token}', ['as' => 'password.reset', 'uses' => 'Auth\PasswordController@getReset']);
    Route::post('reset', ['as' => 'update', 'uses' => 'Auth\PasswordController@postReset']);
    Route::get('reset/cancel/{token}', ['as' => 'password.reset.cancel', 'uses' => 'Auth\PasswordController@cancelPasswordReset']);
});

// Accounts
Route::group(['prefix' => 'account', 'as' => 'accounts.'], function(){
    Route::get('/', ['as' => 'index', 'uses' => 'UsersController@index']);
    Route::get('mybooks', ['as' => 'mybooks', 'uses' => 'UsersController@myBooks']);
    Route::get('change_password', ['as' => 'change_password', 'uses' => 'UsersController@changePassword']);
    Route::patch('change_password', ['as' => 'update_password', 'uses' => 'UsersController@updatePassword'])->before('csrf');
    Route::get('update', ['as' => 'edit', 'uses' => 'UsersController@editInfo']);
    Route::put('update', ['as' => 'update', 'uses' => 'UsersController@updateInfo'])->before('csrf');
});

// Books
Route::group(['prefix' => 'books', 'as' => 'books.'], function(){
    Route::get('/', ['as' => 'index', 'uses' => 'BooksController@index']);
    Route::get('/search', ['as' => 'search', 'uses' => 'BooksController@search']);
    Route::get('/create', ['as' => 'create', 'uses' => 'BooksController@create']);
    Route::get('/{books}', ['as' => 'show', 'uses' => 'BooksController@show'])->where('books', '[0-9]+');
    Route::get('/{books}/edit', ['as' => 'edit', 'uses' => 'BooksController@edit'])->where('books', '[0-9]+');
    Route::put('/{books}/update', ['as' => 'update', 'uses' => 'BooksController@update'])->where('books', '[0-9]+')->before('csrf');
    Route::put('/{books}/sold', ['as' => 'sold', 'uses' => 'BooksController@sold'])->where('books', '[0-9]+')->before('csrf');
    Route::post('/store', ['as' => 'store', 'uses' => 'BooksController@store'])->before('csrf');
    Route::delete('/{books}', ['as' => 'delete', 'uses' => 'BooksController@destroy'])->where('books', '[0-9]+')->before('csrf');
});

// Search
Route::group(['prefix' => 'search', 'as' => 'search.'], function(){
    Route::get('books/', ['as' => 'books', 'uses' => 'SearchController@books']);
    Route::get('books/detailed/', ['as' => 'books.detailed', 'uses' => 'SearchController@booksDetailed']);
});

