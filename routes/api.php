<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AttendanceController;
use App\Http\Controllers\api\ClassController;

Route::controller(AttendanceController::class)->group(function () {
    Route::post('/getClassAttendances', 'getClassAttendances');
    Route::post('/getStudentAttendances', 'getStudentAttendances');

    Route::patch('/updateStudentAttendance/{attendance_id}', 'updateStudentAttendance');
});

Route::controller(ClassController::class)->group(function () {
    Route::get('/getClasses', 'getClasses');
});
