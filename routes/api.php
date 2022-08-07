<?php

use App\Http\Controllers\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/getData/{id}', [App\Http\Controllers\Data::class, 'show']);
Route::post('/data', [App\Http\Controllers\Data::class, 'store']);
Route::post('/loc', [App\Http\Controllers\Data::class, 'storeLocation']);
