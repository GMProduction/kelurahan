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

Route::get('/', function () {
    return view('admin.dashboard');
});


Route::get('/admin', function () {
    return view('admin.dashboard');
});

Route::get('/admin/warga', function () {
    return view('admin.warga');
});

Route::get('/admin/syarat', function () {
    return view('admin.syarat');
});

Route::get('/admin/surat', function () {
    return view('admin.surat');
});

Route::get('/admin/pengurusan', function () {
    return view('admin.pengurusan');
});

Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::post('/register-member', [AuthController::class, 'registerMember']);