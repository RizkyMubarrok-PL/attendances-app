<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\dashboard\UserController;
use App\Http\Controllers\dashboard\ClassController;
use App\Http\Controllers\dashboard\AttendancesController;

Route::get('/', function () {
    return view('login/login');
});

// ini rutenya admin
Route::group(['prefix' => 'dashboard'], function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard');
    });

    // ini rute buat halaman data user
    Route::controller(UserController::class)->group(function () {
        Route::get('/user', 'index')->name('user');
        Route::post('/user/new', 'insert')->name('createUser');
        Route::patch('/user/update', 'update')->name('updateUser');
    });

    // ini rute buat halaman data class
    Route::controller(ClassController::class)->group(function () {
        Route::get('/class', 'index')->name('class');
    });

    // ini rute buat data absensi
    Route::controller(AttendancesController::class)->group(function () {
        Route::get('/attendances', 'index');
    });
});


Route::group(['prefix' => 'guru'], function () {
    Route::controller(GuruController::class)->group(function (){
        Route::get('/', 'index');
        Route::get('/absen', 'absenPage')->name('guruAbsen');

        Route::get('/daftar', 'daftarAbsenPage')->name('daftar');

        Route::get('/rekap', 'rekapPage')->name('rekap');
    });
});

Route::group(['prefix' => 'siswa'], function () {
    Route::controller(SiswaController::class)->group(function () {
        Route::get('/', 'index');

        Route::get('/absensi', 'absensiPage')->name('siswaAbsen');
    });
});