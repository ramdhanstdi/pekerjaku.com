<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\MajikanController;
use App\Http\Controllers\PekerjaController;
use App\Http\Controllers\ProsedurController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoadFileController;
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
Route::get('/login', [AuthController::class, 'loginPage'])->name('login')->middleware('web');
Route::post('/login-post', [AuthController::class, 'loginPost'])->name('login.post')->middleware('web');
Route::get('/registerasi', [AuthController::class, 'registerPage'])->name('registerasi');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/pembayaran/{id}', [AuthController::class, 'pembayaran'])->name('pembayaran');


Route::get('/', [HomeController::class, 'index'])->name('/');

Route::middleware(['auth.login'])->prefix('pekerja')->group(function () {
    Route::get('dashboard', [PekerjaController::class, 'dashboard'])->name('pekerja.dashboard');
    Route::get('data_diri', [PekerjaController::class, 'dataDiri'])->name('pekerja.data_diri');
    Route::get('lowongan', [PekerjaController::class, 'lowongan'])->name('pekerja.lowongan');
    Route::post('review/{id}', [PekerjaController::class, 'updateReview'])->name('pekerja.review');
});

Route::get('lowongan', [LowonganController::class, 'index'])->name('lowongan');
Route::post('lowongan/save', [LowonganController::class, 'save'])->name('lowongan.save');

Route::middleware(['auth.login'])->prefix('majikan')->group(function () {
    Route::get('dashboard', [MajikanController::class, 'index'])->name('majikan.dashboard');
    Route::get('data-pekerja', [MajikanController::class, 'dataPekerja'])->name('majikan.data_pekerja');
    Route::get('data-diri', [MajikanController::class, 'dataDiri'])->name('majikan.data_diri');
    Route::post('data-diri', [MajikanController::class, 'save'])->name('majikan.save');
    Route::get('data-order', [MajikanController::class, 'dataOrder'])->name('majikan.order');
    Route::put('berhenti/{id}', [MajikanController::class, 'stopPekerja'])->name('majikan.berhenti');
});

Route::middleware(['auth.login'])->prefix('admin')->group(function(){
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('pekerja', [AdminController::class, 'pekerja'])->name('admin.pekerja');
    Route::get('user', [AdminController::class, 'user'])->name('admin.user');
    Route::get('lowongan', [AdminController::class, 'lowongan'])->name('admin.lowongan');
    Route::get('order', [AdminController::class, 'order'])->name('admin.order');
    Route::post('/reject-order/{id}', [AdminController::class, 'rejectOrder'])->name('reject.order');
    Route::post('/confirm-order/{id}', [AdminController::class, 'confirmOrder'])->name('confirm.order');
    Route::post('/user/update-payment/{id}', [AdminController::class, 'updateUserPaymentStatus']);
});

Route::get('/pekerja', [PekerjaController::class, 'index'])->name('pekerja');
Route::get('/pekerja/detail/{id}', [PekerjaController::class, 'detailPekerja'])->name('pekerja.detail');
Route::post('/pekerja/detail/{id}', [PekerjaController::class, 'placeOrder'])->name('place.order');

Route::get('/pekerja', [PekerjaController::class, 'pekerja'])->name('pekerja');
Route::get('/prosedur', [ProsedurController::class, 'index'])->name('prosedur');
Route::get('/lowongan', [LowonganController::class, 'index'])->name('lowongan');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');




