<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;;

class MyDashboardController extends Controller
{
    public function index()
    {
        return view('mydashboard');
    }
}