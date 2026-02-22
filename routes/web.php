<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::get('/auth/google/redirect', [LoginController::class, 'googleRedirect']);
Route::get('/auth/google/callback', [LoginController::class, 'googleCallback']);

Route::get('/otp', [OtpController::class, 'index'])->name('otp.form');
Route::post('/otp', [OtpController::class, 'verify'])->name('otp.verify');

Auth::routes();


Route::middleware(['auth'])->group(function () {

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('pdf')->group(function () {
    Route::get('/sertifikat', [PdfController::class, 'sertifikat'])->name('pdf.sertifikat');
    Route::get('/undangan', [PdfController::class, 'undangan'])->name('pdf.undangan');
});

// kategori
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
Route::post('/kategori/store', [KategoriController::class, 'store'])->name('kategori.store');
Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
Route::put('/kategori/{id}/update', [KategoriController::class, 'update'])->name('kategori.update');
Route::delete('/kategori/{id}/destroy', [KategoriController::class, 'destroy'])->name('kategori.destroy');


// buku
Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
Route::post('/buku/store', [BukuController::class, 'store'])->name('buku.store');
Route::get('/buku/{id}/edit', [BukuController::class, 'edit'])->name('buku.edit');
Route::put('/buku/{id}/update', [BukuController::class, 'update'])->name('buku.update');
Route::delete('/buku/{id}/destroy', [BukuController::class, 'destroy'])->name('buku.destroy');

});
