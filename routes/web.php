<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GuruController;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\dashboard\UserController;
use App\Http\Controllers\dashboard\ClassController;
use App\Http\Controllers\dashboard\AttendancesController;

Route::get('/', function () {
    return view('auth/login');
});

// ini rutenya admin
Route::group(['prefix' => 'dashboard'], function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard');
    });

    // ini rute buat halaman data user
    Route::controller(UserController::class)->group(function () {
        Route::get('/user', 'index')->name('user');
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
    });
});