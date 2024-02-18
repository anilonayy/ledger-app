<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'accounts',
], function() {
    Route::middleware('abilities:accounts.create')->post('/create', 'AccountController@store');
    Route::middleware('abilities:accounts.read-all')->get('/user-accounts', 'AccountController@getAllUserAccounts');
    Route::middleware('abilities:accounts.read-all')->get('/user-accounts/{user}', 'AccountController@getUserAccounts');
});
