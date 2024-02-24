<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['auth:sanctum'],
    'prefix' => 'transactions',
], function() {
    Route::middleware('abilities:transactions.give-credit')->post('/give-credit', 'TransactionController@giveCredit');
    Route::middleware('abilities:transactions.transfer')->post('/transfer', 'TransactionController@transferBetweenAccounts');
    Route::middleware('abilities:transactions.withdraw')->post('/withdraw', 'TransactionController@withdraw');
    Route::get('/{account:id}', 'TransactionController@getMyTransactions');
});
