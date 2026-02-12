<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;;

class LaporanpmController extends Controller
{
    public function index()
    {
        return view('laporanPM');
    }
}