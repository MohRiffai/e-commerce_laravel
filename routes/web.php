<?php

use App\Http\Controllers\Auth\ProviderController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\ProfileController;
use Illuminate\Auth\Events\Verified;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\LaporanPenjualanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\RiwayatTransaksiController;
use App\Http\Controllers\CekOngkirController;
use App\Http\Controllers\LaporanPenjualanContoller;
use App\Http\Controllers\UserController;
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

//Route ecommerce
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('produk/{kategori}', [HomeController::class, 'produk'])->name('home.produk');
Route::get('kategori/{category}', [HomeController::class, 'kategori'])->name('home.kategori');
Route::get('search', [HomeController::class, 'search'])->name('home.search');
// Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
// Route::post('checkout', [CheckoutController::class, 'cekOngkir'])->name('checkout.cekOngkir');
// Route::post('/cart/update/{key}', [CartController::class, 'update'])->name('cart.update');
// Route::post('/confirm', [CartController::class, 'confirm'])->name('confirm.product');

// Route::get('auth/{provider}redirect', [ProviderController::class, 'redirect']);

// Route::get('/auth/{provider}callback', [ProviderController::class, 'callback']);

Route::middleware(['auth', 'verified'])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    //Route Keranjang
    Route::get('cart', [KeranjangController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [KeranjangController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [KeranjangController::class, 'remove'])->name('cart.remove');
    Route::post('/checkout', [KeranjangController::class, 'checkout'])->name('checkout');
    Route::get('cart/count', [KeranjangController::class, 'count']);


    route::get(uri: 'dashboard', action: DashboardController::class)->name(name: 'dashboard');

    // Route produk
    route::resource(name: 'produk', controller: ProdukController::class);
    route::post('/produk/edit', [ProdukController::class, 'edit'])->name('produk.edit');

    // Route Kasir
    route::resource(name: 'kasir', controller: KasirController::class);
    Route::post('/transaction', [KasirController::class, 'store'])->name('transaction.store');
    Route::get('/transaction/success', [KasirController::class, 'success'])->name('transaction.sukses');
    Route::get('/nota/{id}', [KasirController::class, 'nota'])->name('transaksi_nota');
    Route::get('/cetak-nota/{id}', [KasirController::class, 'cetakNota'])->name('transaction.cetakNota');

    // Route Laporan Penjualan
    route::resource(name: 'laporan_penjualan', controller: LaporanPenjualanController::class);
    Route::get('/cek_penjualan', [LaporanPenjualanController::class, 'cekPenjualan'])->name('cek_penjualan');
    Route::get('/cetak_penjualan_semua_tanggal', [LaporanPenjualanController::class, 'cetakPenjualanSemuaTanggal'])->name('cetak_penjualan_semua_tanggal');
    Route::get('/cetak_penjualan_semua', [LaporanPenjualanController::class, 'cetakPenjualanSemua'])->name('cetak_penjualan_semua');
    Route::get('/laporan_penjualan_online', [LaporanPenjualanController::class, 'indexOnline'])->name('penjualan_online');
    Route::get('/cek_penjualan_online', [LaporanPenjualanController::class, 'cekPenjualanOnline'])->name('cek_penjualan_online');
    Route::get('/cetak_penjualan_online_tanggal', [LaporanPenjualanController::class, 'cetakPenjualanOnlineTanggal'])->name('cetak_penjualan_online_tanggal');
    Route::get('/cetak_penjualan_online_semua', [LaporanPenjualanController::class, 'cetakPenjualanOnline'])->name('cetak_penjualan_online_semua');
    Route::get('/invoice_online/{id}', [LaporanPenjualanController::class, 'tampilInvoiceOnline'])->name('invoice_online');
    Route::put('/transaksi/{id}/status-owner', [LaporanPenjualanController::class, 'updateStatusOwner'])->name('updateStatusOwner');
    Route::get('/laporan_penjualan_offline', [LaporanPenjualanController::class, 'indexOffline'])->name('penjualan_offline');
    Route::get('/cek_penjualan_offline', [LaporanPenjualanController::class, 'cekPenjualanOffline'])->name('cek_penjualan_offline');
    Route::get('/cetak_penjualan_offline_tanggal', [LaporanPenjualanController::class, 'cetakPenjualanOfflineTanggal'])->name('cetak_penjualan_offline_tanggal');
    Route::get('/cetak_penjualan_offline_semua', [LaporanPenjualanController::class, 'cetakPenjualanOffline'])->name('cetak_penjualan_offline_semua');
    Route::get('/nota_kasir/{id}', [LaporanPenjualanController::class, 'nota'])->name('transaction.nota_offline');
    // Route Kategori
    route::resource(name: 'kategori', controller: KategoriController::class);
    route::post('/kategori/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    // Route::post('update', [App\Http\Controllers\KategoriController::class, 'update'])->name('kategori.update');
    // Route::post('/kategori/edit', [\App\Http\Controllers\KategoriController::class, 'edit'])->name('kategori.edit');
    // Route::post('/kategori/update', [\App\Http\Controllers\KategoriController::class, 'update'])->name('kategori.update');

    // Route Riwayat Transaksi
    route::resource(name: 'riwayat_transaksi', controller: RiwayatTransaksiController::class);
    Route::get('/input-alamat/{id}', [RiwayatTransaksiController::class, 'showInputAlamat'])->name('input.alamat');
    Route::post('/simpan-alamat', [RiwayatTransaksiController::class, 'simpanAlamat'])->name('simpan.alamat');
    Route::get('/cek-ongkir/{id}', [RiwayatTransaksiController::class, 'cekOngkir'])->name('cek.ongkir');
    Route::post('/simpan-ongkir', [RiwayatTransaksiController::class, 'simpanOngkridanTotal'])->name('simpan.ongkir');
    Route::get('/checkout/{id}', [RiwayatTransaksiController::class, 'showTransaction'])->name('transaction.show');
    Route::get('/checkout/success/{id}', [RiwayatTransaksiController::class, 'success'])->name('transaction.success');
    Route::get('/invoice/{id}', [RiwayatTransaksiController::class, 'tampilInvoice'])->name('invoice.show');
    Route::get('/download-invoice/{id}', [RiwayatTransaksiController::class, 'downloadInvoice'])->name('download.invoice');
    Route::delete('/transaksi/{id}', [RiwayatTransaksiController::class, 'destroy'])->name('transaksi.destroy');
    // Route::get('cek_ongkir/{riwayattransaksi}', [RiwayatTransaksiController::class, 'indexCekOngkir'])->name('cekongkir.index');
    // Route::post('cek_ongkir/{riwayattransaksi}', [RiwayatTransaksiController::class, 'cekOngkir'])->name('cekongkir.cekOngkir');
    // Route::get('riwayat_transaksi', [RiwayatTransaksiContoller::class, 'index'])->name('riwayat_transaksi.index');

    //Route User
    Route::resource(name: 'user', controller: UserController::class);
    Route::get('/profile', [UserController::class, 'profileIndex'])->name('profile.index');
    Route::get('/profile/edit', [UserController::class, 'profileEdit'])->name('profile.edit');
    Route::put('/profile/update', [UserController::class, 'profileUpdate'])->name('profile.update');

    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Route::middleware('auth')->group(function () {

// });

require __DIR__ . '/auth.php';
