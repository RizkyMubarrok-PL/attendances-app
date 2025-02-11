<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

Route::get('/laporan', function () {
    return view('dashboard.adminlaporan');
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
        Route::get('/user/search', 'index')->name('userSearch');
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
        Route::get('/report/{status?}', 'index')->name('report');
        Route::post('/report/{status?}', 'search')->name('reportSearch');
    });
});

// rute guru
Route::group(['prefix' => 'guru', 'middleware' => 'role:guru'], function () {
    Route::controller(GuruController::class)->group(function () {
        Route::get('/', 'index')->name('guruHome');

        Route::get('/absensi/class', 'updateAbsensiPage')->name('updateAbsenPage');
        Route::post('/absensi/class/{className?}', 'dataAbsensiPerKelas')->name('dataAbsenPage');
        Route::post('/absensi/class/{className?}/update', 'updateAbsensi')->name('updateAbsen');

        Route::get('/absensi/rekap/{className?}/{filter?}/{filterValue?}', 'rekapPage')->name('rekapGuruPage');

        Route::get('/absensi/{className?}', 'listAbsensiPage')->name('listAbsenPage');
        Route::post('/absensi/{className}/{filter}/{filterValue}', 'listAbsensiPage')->name('listAbsenFilter');

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
