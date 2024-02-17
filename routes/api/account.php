<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'accounts',
], function() {
    Route::post('/create', 'AccountController@store');
});
