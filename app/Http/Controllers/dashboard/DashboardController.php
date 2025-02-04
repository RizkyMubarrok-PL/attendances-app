<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Classes;
use App\Models\User;
use App\Models\Attendances;

class DashboardController extends Controller
{
    public function index(Classes $classes, User $users, Attendances $attendances) {
        $totalUsers = $users->count();
        $totalClasses = $classes->count();
        $totalTeachers = $users->where('role', 'Guru')->count();
        $totalHadir = $attendances->countStatusAttendances('Hadir');
        $totalIzin = $attendances->countStatusAttendances('Izin');
        $totalAlpha = $attendances->countStatusAttendances('Alpha');

        return view('dashboard.admin', [
            'totalUsers' => $totalUsers, 
            'totalClasses' => $totalClasses, 
            'totalTeachers' => $totalTeachers,
            'totalHadir' => $totalHadir, 
            'totalIzin' => $totalIzin, 
            'totalAlpha' => $totalAlpha, 
        ]);
    }
}
