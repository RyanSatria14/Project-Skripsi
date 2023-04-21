<?php

use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

// Home route
Route::get('/', function () {
    return view('landing');
})->middleware('language');

Route::get('/validasi', function () {
    return view('validasi');
})->middleware('language');

// Auth routes
Route::group(['middleware' => 'language'], function () {
    Route::get('login', 'LoginController@index')->middleware('islogin');
    Route::post('login', 'LoginController@auth');
    Route::get('register', 'LoginController@registerView');
    Route::post('register', 'LoginController@register');
    Route::get('register-admin', 'LoginController@registerAdminView');
    Route::post('register-admin', 'LoginController@registerAdmin');
    Route::get('logout', 'LoginController@logout');
});


// Admin routes
Route::group(['prefix' => 'admin', 'middleware' => ['language', 'islogin']], function () {
    Route::get('/', 'Admin@index');
    Route::get('input-transaksi', 'Admin@inputTransaksi');
    Route::get('hapus-transaksi/{row_id}', 'Admin@hapusTransaksi');
    Route::post('tambah-transaksi', 'Admin@tambahTransaksi');
    Route::post('simpan-transaksi', 'Admin@simpanTransaksi');
    Route::get('hapus-sesstransaksi', 'Admin@hapusSessTransaksi');
    Route::post('ambil-detail-transaksi', 'Admin@ambilDetailTransaksi');
    Route::post('ubah-status-transaksi', 'Admin@ubahStatusTransaksi');
    Route::get('transaksi', 'Admin@riwayatTransaksi');
    Route::post('/transaksi/priority', 'Admin@getTransaksiPriority')->name('a.transaksi.priority');
    Route::post('/transaksi/berjalan', 'Admin@getTransaksiBerjalan')->name('a.transaksi.berjalan');
    Route::post('/transaksi/selesai', 'Admin@getTransaksiSelesai')->name('a.transaksi.selesai');
    Route::get('cetak-transaksi/{id}', 'Admin@cetakTransaksi');
    Route::get('harga', 'Admin@harga');
    Route::post('/get/kiloan', 'Admin@getDataKiloan')->name('a.kiloan.list');
    Route::post('/get/satuan', 'Admin@getDataSatuan')->name('a.satuan.list');
    Route::post('/get/service', 'Admin@getDataService')->name('a.service.list');
    Route::post('ambil-harga', 'Admin@ambilHarga');
    Route::post('tambah-harga', 'Admin@tambahHarga');
    Route::post('ubah-harga', 'Admin@ubahHarga');
    Route::post('tambah-barang', 'Admin@tambahBarang');
    Route::post('tambah-servis', 'Admin@tambahServis');
    Route::get('members', 'Admin@members');
    Route::post('/members/list', 'Admin@getDataMembers')->name('a.member.list');
    Route::get('voucher', 'Admin@voucher');
    Route::post('/voucher/list', 'Admin@getDataVoucher')->name('a.voucher.list');
    Route::get('notifikasi', 'Admin@notifikasi');
    Route::post('detail-notifikasi', 'Admin@detailNotifikasi');
    Route::post('voucher/tambah', 'Admin@tambahVoucher');
    Route::post('voucher/ubahaktif', 'Admin@ubahAktifVoucher');
    Route::get('saran', 'Admin@saran');
    Route::post('ambil-sarankomplain', 'Admin@ambilSaranKomplain');
    Route::post('kirim-balasan', 'Admin@kirimBalasan');
    Route::get('laporan', 'Admin@laporan');
    Route::post('get-month', 'Admin@getMonth');
    Route::post('cetak-laporan', 'Admin@cetakLaporan');
    Route::get('laporanview', 'Admin@laporanview');
    Route::get('get-service-type', [Admin::class, 'getServiceType']);
    Route::patch('update-service-type', [Admin::class, 'updateServiceType']);
    Route::get('/hapus-harga1/{id}', 'Admin@hapusHargaSatuan');
    Route::get('/hapus-harga2/{id}', 'Admin@hapusHargaKiloan');
    Route::get('/hapus-voucher/{id}', 'Admin@hapusVoucher');
});

//Member routes
Route::group(['prefix' => 'member', 'middleware' => ['language', 'islogin']], function () {
    Route::get('/', 'Member@index');
    Route::get('harga', 'Member@harga');
    Route::post('/get/kiloan', 'Member@getDataKiloan')->name('m.kiloan.list');
    Route::post('/get/satuan', 'Member@getDataSatuan')->name('m.satuan.list');
    Route::post('/get/service', 'Member@getDataService')->name('m.service.list');
    Route::get('poin', 'Member@poin');
    Route::get('poin/tukar/{id_voucher}', 'Member@tukarPoin');
    Route::get('transaksi', 'Member@riwayatTransaksi');
    Route::post('/get/transaksi', 'Member@getTransaksi')->name('m.transaksi.list');
    Route::get('transaksi/{id_transaksi}', 'Member@detailTransaksi');
    Route::get('saran', 'Member@saranKomplain');
    Route::post('kirimsaran', 'Member@kirimSaranKomplain');
    Route::get('notifikasi', 'Member@notifikasi');
    Route::post('detail-notifikasi', 'Member@detailNotifikasi');
    Route::get('/hapus-saran/{id}', 'Member@hapusSaran');
});

// User profile routes
Route::group(['prefix' => 'profile', 'middleware' => ['language', 'islogin']], function () {
    Route::get('/', 'UserController@index');
    Route::get('resetfoto', 'UserController@resetfoto');
    Route::patch('/', 'UserController@editprofil');
    Route::patch('password', 'UserController@editpassword');
});

// Set language route
Route::get('/{locale}', function ($locale, Request $request) {
    if (!in_array($locale, ['en', 'id'])) {
        abort(404);
    }
    $request->session()->put('locale', $locale);
    return redirect()->back();
});
