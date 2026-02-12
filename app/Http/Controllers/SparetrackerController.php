<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;;

class SparetrackerController extends Controller
{
    public function index()
    {
        return view('sparetracker');
    }
}