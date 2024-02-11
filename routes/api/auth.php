<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'sanctum.guest',
    'prefix' => 'auth',
], function() {
    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'AuthController@register');
});
