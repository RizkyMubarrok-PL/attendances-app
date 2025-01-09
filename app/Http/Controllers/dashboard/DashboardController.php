<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Classes;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Classes $classes, User $users) {
        $totalUsers = $users->count();
        $totalClasses = $classes->count();
        $totalTeachers = $users->where('role', 'Guru')->count();

        return view('dashboard.admin', ['totalUsers' => $totalUsers, 'totalClasses' => $totalClasses, 'totalTeachers' => $totalTeachers]);
    }
}
