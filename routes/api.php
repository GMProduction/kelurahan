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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
    Route::post('register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
});


Route::group(['middleware' => 'auth:api', 'prefix' => 'surat'], function () {
    Route::get('/', [\App\Http\Controllers\Api\SuratController::class, 'getList']);
    Route::match(['get', 'post'], '/{id}', [\App\Http\Controllers\Api\SuratController::class, 'getDetail']);
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'pengurusan'], function () {
    Route::get('/', [\App\Http\Controllers\Api\PengurusanController::class, 'index']);
    Route::match(['get', 'post'], '/{id}', [\App\Http\Controllers\Api\PengurusanController::class, 'detail']);
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'profil'], function () {
    Route::match(['get', 'post'], '/', [\App\Http\Controllers\Api\ProfileController::class, 'index']);
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'berita'], function () {
    Route::get('/', [\App\Http\Controllers\Api\BeritaController::class, 'index']);
    Route::get('/{id}', [\App\Http\Controllers\Api\BeritaController::class, 'detail']);
});


