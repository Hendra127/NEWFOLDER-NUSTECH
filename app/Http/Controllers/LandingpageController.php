<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingpageController extends Controller
{
    public function index()
    {
        // Pastikan nama file blade Anda adalah 'landing.blade.php'
        return view('landingpage');
    }

    public function todo()
    {
        return view('pages.todo'); 
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request.session()->invalidate();
        $request.session()->regenerateToken();
        return redirect('/');
    }
}