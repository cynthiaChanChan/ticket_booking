<?php

Route::get('/concerts/{id}', 'concertController@show');

Route::post('/concerts/{id}/orders', 'concertOrdersController@store');

Route::get('/orders/{confirmationNumber}', 'ordersController@show');

Route::post('/login', 'Auth\LoginController@login');