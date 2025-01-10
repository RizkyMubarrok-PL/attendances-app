<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index() {
        return view('siswa.siswa');
    }

    public function absensiPage() {
        return view('siswa.absensisiswa');
    }
}
