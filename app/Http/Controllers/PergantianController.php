<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;;

class PergantianController extends Controller
{
    public function index()
    {
        return view('pergantianperangkat');
    }
}