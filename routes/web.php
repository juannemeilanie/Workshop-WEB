<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\WilayahController;
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

    // barang
    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/barang/store', [BarangController::class, 'store'])->name('barang.store');
    Route::get('/barang/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
    Route::put('/barang/{id}/update', [BarangController::class, 'update'])->name('barang.update');
    Route::delete('/barang/{id}/destroy', [BarangController::class, 'destroy'])->name('barang.destroy');
    Route::get('/barang/cetak', [BarangController::class, 'cetak'])->name('barang.cetak');
    // Scan Barcode 
    Route::get('/barang/scan', [BarangController::class, 'scan'])->name('barang.scan');
    Route::post('/barang/scan/find', [BarangController::class, 'findByBarcode'])->name('barang.scan.find');

    Route::get('/table', function () {return view('table.Table-html');})->name('Table');
    Route::get('/table/datatables', function () {return view('table.datatables');})->name('Datatables');
    Route::get('/table/kota', function () {return view('table.kota');})->name('kota');

    Route::get('/wilayah', [WilayahController::class, 'index'])->name('wilayah.index');
    Route::get('/wilayah/provinsi', [WilayahController::class, 'getProvinsi'])->name('wilayah.provinsi');
    Route::post('/wilayah/kota', [WilayahController::class, 'getKota'])->name('wilayah.kota');
    Route::post('/wilayah/kecamatan', [WilayahController::class, 'getKecamatan'])->name('wilayah.kecamatan');
    Route::post('/wilayah/kelurahan', [WilayahController::class, 'getKelurahan'])->name('wilayah.kelurahan');

    Route::get('/pos/jquery', [PosController::class, 'index1'])->name('pos.index1');
    Route::get('/pos/axios', [PosController::class, 'index2'])->name('pos.index2');
    Route::get('/pos/barang/{id}', [PosController::class, 'getBarang'])->name('pos.barang');
    Route::post('/simpan-transaksi', [PosController::class, 'simpan'])->name('pos.simpan');
    Route::post('/simpan-transaksi-axios',[PosController::class, 'simpanAxios'])->name('pos.simpan.axios');

    Route::get('/data/vendor', [VendorController::class, 'index'])->name('vendor.daftar');
    

    // VENDOR
    Route::get('/vendor/dashboard', [VendorController::class, 'dashboard']);
    Route::get('/vendor/menu', [VendorController::class, 'menu'])->name('vendor.menu.index');
    Route::get('/vendor/menu/create', [VendorController::class, 'create'])->name('vendor.menu.create');
    Route::post('/vendor/menu', [VendorController::class, 'store'])->name('vendor.menu.store');
    Route::get('/vendor/menu/{id}/edit', [VendorController::class, 'edit'])->name('vendor.menu.edit');
    Route::put('/vendor/menu/{id}', [VendorController::class, 'update'])->name('vendor.menu.update');
    Route::delete('/vendor/menu/{id}', [VendorController::class, 'destroy'])->name('vendor.menu.delete');
    Route::get('/vendor/pesanan/scan', [VendorController::class, 'scanPage'])->name('vendor.pesanan.scan');
    Route::post('/vendor/pesanan/scan/read', [VendorController::class, 'readQrCode'])->name('vendor.pesanan.scan.read');
    Route::get('/vendor/pesanan', [VendorController::class, 'pesanan'])->name('vendor.pesanan.index');
    Route::get('/vendor/pesanan/{id}', [VendorController::class, 'detailPesanan']) ->name('vendor.pesanan.detail');

    // TOKO
    Route::get('/toko', [TokoController::class, 'index'])->name('toko.index');
    Route::get('/toko/create', [TokoController::class, 'create'])->name('toko.create');
    Route::post('/toko', [TokoController::class, 'store'])->name('toko.store');
    Route::get('/toko/kunjungan', [TokoController::class, 'kunjungan'])->name('toko.kunjungan');
    Route::get('/toko/barcode', [TokoController::class, 'findByBarcode'])->name('toko.barcode');
    Route::post('/toko/cek', [TokoController::class, 'cekKunjungan'])->name('toko.cek');
    Route::get('/toko/{toko}/cetak-barcode', [TokoController::class, 'cetakBarcode'])->name('toko.cetak');

});

// CUSTOMER
Route::get('/order', [PesananController::class, 'index'])->name('pesanan.index');
Route::post('/pesanan/store', [PesananController::class, 'store'])->name('pesanan.store');
Route::get('/bayar/{id}', [PaymentController::class, 'show']);
Route::post('/payment/token', [PaymentController::class, 'token']);
Route::post('/payment/callback', [PaymentController::class, 'callback']);
Route::get('/payment/success/{id}', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/customer/qrcode/{id}', [PaymentController::class, 'showQrCode'])->name('customer.qrcode');

Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
Route::delete('/customer/{id}/destroy', [CustomerController::class, 'destroy'])->name('customer.destroy');


Route::get('/customer/create1', [CustomerController::class, 'create1'])->name('customer.create1');
Route::post('/customer/store1', [CustomerController::class, 'store1'])->name('customer.store1');


Route::get('/customer/create2', [CustomerController::class, 'create2'])->name('customer.create2');
Route::post('/customer/store2', [CustomerController::class, 'store2'])->name('customer.store2');