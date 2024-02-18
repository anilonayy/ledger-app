<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['auth:sanctum'],
    'prefix' => 'transactions',
], function() {
    Route::middleware('abilities:give-credit')->post('/give-credit', 'TransactionController@giveCredit');
});
