<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;;

class PMLibertaController extends Controller
{
    public function index()
    {
        return view('PMLiberta');
    }
}