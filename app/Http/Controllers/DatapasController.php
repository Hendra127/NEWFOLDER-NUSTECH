<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;
use App\Models\DataPass;
use Illuminate\Support\Facades\DB;

class DatapasController extends Controller
{
    public function index(Request $request)
    {
        $query = DataPass::with('site');

        // SEARCH
        if ($request->filled('search')) {
            $query->where('nama_lokasi', 'like', '%' . $request->search . '%')
                ->orWhere('kabupaten', 'like', '%' . $request->search . '%')
                ->orWhereHas('site', function ($q) use ($request) {
                        $q->where('site_id', 'like', '%' . $request->search . '%');
                });
        }

        $datapass = $query->paginate(20)->withQueryString();

        // ambil master site untuk dropdown modal
        $sites = Site::all();

        return view('datapas', compact('datapass','sites'));
    }

    public function show($id)
    {
        $site = Site::with('datapasses')->findOrFail($id);
        return view('datapas_show', compact('site'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'site_id' => 'required|exists:sites,id',
            'nama_lokasi' => 'required',
            'kabupaten' => 'required',
            'adop' => 'nullable',
            'pass_ap1' => 'nullable',
            'pass_ap2' => 'nullable',
        ]);

        DataPass::create($validated);

        return back()->with('success','Berhasil disimpan');
    }

}
