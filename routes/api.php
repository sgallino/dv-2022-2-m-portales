<?php

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

Route::get('/peliculas', [\App\Http\Controllers\API\PeliculasController::class, 'list']);
Route::get('/peliculas/{id}', [\App\Http\Controllers\API\PeliculasController::class, 'get']);
Route::post('/peliculas', [\App\Http\Controllers\API\PeliculasController::class, 'create']);
