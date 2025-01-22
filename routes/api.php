<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AttendanceController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\ClassController;

Route::get('/test', function() {
    return response()->json([
        'connect' => true,
    ], 200);
});

Route::controller(AttendanceController::class)->group(function () {
    Route::post('/getClassAttendances', 'getClassAttendances');
    Route::post('/getStudentAttendances', 'getStudentAttendances');

    Route::patch('/updateStudentAttendance/{attendance_id}', 'updateStudentAttendance');
});

Route::controller(ClassController::class)->group(function () {
    Route::get('/getClasses', 'getClasses');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
});