<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    try {
        $status = true;
        App\Models\User::find(25);
    } catch (\Exception $e) {
        $status = false;
    }

    return response()->json([
        'message' => 'Welcome to the Ledger App.',
        'db_health' => $status ? 'ok' : 'error',
        'status' => 1923
    ]);
});
