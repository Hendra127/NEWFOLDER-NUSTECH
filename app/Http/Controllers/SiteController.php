<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index(Request $request)
    {
        $query = Site::query();

        // SEARCH
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('site_id', 'like', '%' . $request->search . '%')
                  ->orWhere('sitename', 'like', '%' . $request->search . '%')
                  ->orWhere('provinsi', 'like', '%' . $request->search . '%')
                  ->orWhere('kab', 'like', '%' . $request->search . '%');
            });
        }

        $sites = $query->paginate(20)->withQueryString();

        return view('datasite', compact('sites'));
    }
}
