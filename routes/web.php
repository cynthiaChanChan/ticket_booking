<?php

Route::get('/concerts/{id}', 'concertController@show')->name('concerts.show');

Route::post('/concerts/{id}/orders', 'concertOrdersController@store');

Route::get('/orders/{confirmationNumber}', 'ordersController@show');

Route::get('/login', 'Auth\LoginController@showLoginForm')->name('auth.show-login');
Route::post('/login', 'Auth\LoginController@login')->name('auth.login');
Route::post('/logout', 'Auth\loginController@logout')->name('auth.logout');

Route::get('/invitations/{code}', 'InvitationsController@show');
Route::post('/register', 'Auth\RegisterController@register')->name('auth.register');

Route::group(['middleware' => 'auth', 'prefix'=> 'backstage', 'namespace' => 'Backstage'], function () {
    Route::get('/concerts/new', 'ConcertsController@create');
    Route::post('/concerts', 'ConcertsController@store');
});


