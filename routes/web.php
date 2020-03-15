<?php

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

Route::get('validasi/{link}','qrcodeSetupController@showqr');
Route::get('tes','presensiController@distance');
Route::get('asu', function () {
    // session(['key' => '123']);
    return view('tes');
});

Auth::routes();

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/home', 'HomeController@index');
Route::group(['prefix' => 'admin' ,'middleware' => ['isAdmin']], function () {
    Route::get('/','adminDashboardController@index')->name('home');
    Route::get('karyawan','adminDashboardController@karyawan')->name('admin.karyawan');
    Route::get('user','adminDashboardController@user')->name('admin.user');
    Route::get('absen','adminDashboardController@presensi')->name('admin.presensi');
    Route::get('link-validasi','adminDashboardController@linkVal')->name('admin.link');
    Route::get('absen/{id}', 'presensiController@show')->name('presensi.karyawan');
    Route::get('absen/{user}/bulan/{month}', [
        'as' => 'presensiByMonth', 'uses' => 'presensiController@showByMonth']);
    Route::get('absen/bulan/{id}', 'presensiController@showByMonth')->name('presensi.month.karyawan');
    Route::get('link-val/tambah','qrcodesetupController@create')->name('manajemen.link.add');
    Route::post('link-val','qrcodesetupController@generate')->name('manajemen.link.simpan');
    Route::get('link-val/hapus/{id}','qrcodesetupController@hapus')->name('manajemen.link.hapus');
    Route::get('link-val/edit/{id}','qrcodesetupController@edit')->name('manajemen.link.edit');
    Route::post('link-val/ubah/{id}','qrcodesetupController@ubah')->name('manajemen.link.ubah');
    Route::get('link-val/lihat/{id}','qrcodesetupController@lihat')->name('manajemen.link.lihat');
    Route::get('link-val/aktif/{id}','qrcodesetupController@aktifkan')->name('manajemen.link.aktifkan');
    Route::get('link-val/mati/{id}','qrcodesetupController@matikan')->name('manajemen.link.matikan');
    Route::get('link-val/verif/{id}','qrcodesetupController@disetujui')->name('manajemen.link.verif');
});

Route::group(['prefix' => 'karyawan' ,'middleware' => ['isAdmin']], function () {
    Route::get('tambah','KaryawanController@create')->name('karyawan.add');
    Route::post('simpan','KaryawanController@store')->name('karyawan.store');
    Route::get('ubah/{id}','KaryawanController@edit')->name('karyawan.edit');
    Route::post('perbarui/{id}','KaryawanController@update')->name('karyawan.update');
    Route::get('lihat/{id}','KaryawanController@show')->name('karyawan.show');
    Route::get('hapus/{id}','KaryawanController@destroy')->name('karyawan.destroy');
    Route::get('reset/{id}','KaryawanController@res_teleg')->name('karyawan.reset');
});

Route::group(['middleware' => ['cekStatus']], function () {
    Route::get('presensi','presensiController@indexPresensi')->name('karyawan.presensi');
    Route::get('presensi/scanner','presensiController@scannerPresensi')->name('karyawan.scanner');
    Route::get('presensi/request','presensiController@indexRequestLink')->name('karyawan.request');
    Route::post('presensi/request','qrcodeSetupController@simpanRequestLink')->name('karyawan.request.simpan');
});

Route::group(['prefix' => 'pengguna' ,'middleware' => ['isAdmin']], function () {
    Route::get('buat/{id}','userController@create')->name('user.add');
    Route::post('simpan/{id}','userController@store')->name('user.store');
    Route::get('ubah/{id}','userController@edit')->name('user.edit');
    Route::post('perbarui/{id}','userController@update')->name('user.update');
    Route::get('lihat/{id}','userController@show')->name('user.show');
    Route::get('hapus/{id}','userController@destroy')->name('user.destroy');
});
Route::group(['prefix' => 'presensi' ,'middleware' => ['isAdmin']], function () {
    Route::get('ubah/{id}','userController@edit')->name('user.edit');
    Route::post('perbarui/{id}','userController@update')->name('user.update');
});

