<?php

use App\Http\Controllers\Admin\BanerController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RajaOngkirController;
use App\Http\Controllers\User\DikemasController;
use App\Http\Controllers\User\KeranjangController;
use App\Http\Controllers\User\MenungguController;
use App\Http\Controllers\User\PembayaranController;
use App\Http\Controllers\User\PengirimanController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\SelesaiController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::match(['get', 'post'],'/', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::prefix('admin')->group(function () {

    Route::get('/', function () {
        return view('admin.dashboard');
    });

    Route::prefix('warga')->group(function () {
        Route::match(['post', 'get'], '/', [\App\Http\Controllers\WargaController::class, 'index']);
        Route::post('/patch', [\App\Http\Controllers\WargaController::class, 'patch']);
        Route::post('/delete', [\App\Http\Controllers\WargaController::class, 'hapus']);
    });

    Route::prefix('syarat')->group(function () {
        Route::match(['post', 'get'], '/', [\App\Http\Controllers\SyaratController::class, 'index']);
        Route::post('/patch', [\App\Http\Controllers\SyaratController::class, 'patch']);
        Route::post('/delete', [\App\Http\Controllers\SyaratController::class, 'hapus']);
    });

    Route::prefix('surat')->group(function () {
        Route::match(['post', 'get'], '/', [\App\Http\Controllers\SuratController::class, 'index']);
        Route::post('/store', [\App\Http\Controllers\SuratController::class, 'store']);
        Route::get('/syarat', [\App\Http\Controllers\SuratController::class, 'getSyarats']);
        Route::post('/patch', [\App\Http\Controllers\SuratController::class, 'patch']);
        Route::post('/delete', [\App\Http\Controllers\SuratController::class, 'hapus']);
    });

    Route::prefix('pengurusan')->group(function () {
        Route::match(['post', 'get'], '/', [\App\Http\Controllers\PengurusanController::class, 'index']);
        Route::get('/syarat', [\App\Http\Controllers\PengurusanController::class, 'getSyarats']);
        Route::post('/patch', [\App\Http\Controllers\PengurusanController::class, 'patch']);
    });

    Route::prefix('berita')->group(function () {
        Route::match(['post', 'get'], '/', [\App\Http\Controllers\BeritaController::class, 'index']);
        Route::post('/patch', [\App\Http\Controllers\BeritaController::class, 'patch']);
        Route::post('/delete', [\App\Http\Controllers\BeritaController::class, 'hapus']);
    });


});


Route::post('/register-member', [AuthController::class, 'registerMember']);
