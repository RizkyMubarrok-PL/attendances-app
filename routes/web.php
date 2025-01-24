<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\dashboard\UserController;
use App\Http\Controllers\dashboard\ClassController;
use App\Http\Controllers\dashboard\AttendancesController;

Route::get('/', function () {
    return view('login/login');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login')->name('login');
    Route::get('/logout', 'logout')->name('logout');
});

// ini rutenya admin
Route::group(['prefix' => 'dashboard', 'middleware' => 'role:admin'], function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard');
    });

    // ini rute buat halaman data user
    Route::controller(UserController::class)->group(function () {
        Route::get('/user', 'index')->name('user');
        Route::post('/user/new', 'insert')->name('createUser');
        Route::patch('/user/update', 'update')->name('updateUser');
        Route::delete('/user/delete', 'delete')->name('deleteUser');
    });

    // ini rute buat halaman data class
    Route::controller(ClassController::class)->group(function () {
        Route::get('/class', 'index')->name('class');
        Route::post('/class/new', 'insert')->name('createClass');
        Route::patch('/class/update', 'update')->name('updateClass');
        Route::delete('/class/delete', 'delete')->name('deleteClass');
    });

    // ini rute buat data absensi
    Route::controller(AttendancesController::class)->group(function () {
        Route::get('/attendances', 'index');
    });
});

// rute guru
Route::group(['prefix' => 'guru', 'middleware' => 'role:guru'], function () {
    Route::controller(GuruController::class)->group(function (){
        Route::get('/', 'index');
        Route::get('/absen', 'absenPage')->name('guruAbsen');

        Route::get('/daftar', 'daftarAbsenPage')->name('daftar');
        Route::post('/absen/class', 'absenPerKelas')->name('getAbsen');

        Route::post('/absen/update', 'updateAbsensi')->name('updateAbsen');

        Route::get('/rekap', 'rekapPage')->name('rekap');
    });
});

// rute siswa
Route::group(['prefix' => 'siswa', 'middleware' => 'role:siswa'], function () {
    Route::controller(SiswaController::class)->group(function () {
        Route::get('/', 'index');

        Route::get('/absensi', 'absensiPage')->name('siswaAbsen');
        Route::post('/absensiDate', 'absensiDate')->name('absensiDate');        
        Route::post('/absensiMonths', 'absensiMonths')->name('absensiMonths');
    });
});