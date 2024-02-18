<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'accounts',
], function() {
    Route::middleware('abilities:accounts.create')->post('/create', 'AccountController@store');
    Route::middleware('abilities:accounts.read-own')->get('/my-accounts', 'AccountController@getMyAccounts');
    Route::middleware('abilities:accounts.read-all')->get('/user-accounts', 'AccountController@getAllUserAccounts');
    Route::middleware('abilities:accounts.read-all')->get('/user-accounts/{user}', 'AccountController@getUserAccounts');
    Route::middleware('abilities:accounts.balance-at-time')->post('/balance-at-time', 'AccountController@getBalanceAtTime');
});
