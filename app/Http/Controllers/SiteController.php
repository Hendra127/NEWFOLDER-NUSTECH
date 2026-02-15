<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;
use App\Imports\SitesImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use App\Exports\SitesExport;

class SiteController extends Controller
{
    public function index(Request $request)
    {
        $query = Site::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('site_id', 'like', '%' . $request->search . '%')
                  ->orWhere('sitename', 'like', '%' . $request->search . '%')
                  ->orWhere('provinsi', 'like', '%' . $request->search . '%')
                  ->orWhere('kab', 'like', '%' . $request->search . '%');
            });
        }
        
        $sites = $query->latest()->paginate(20)->withQueryString();
        return view('datasite', compact('sites'));
    }

    public function import(Request $request) 
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new SitesImport, $request->file('file'));
            return redirect()->back()->with('success', 'Data Site berhasil diimport!');
        } catch (\Exception $e) {
            Log::error('Gagal Import Excel: ' . $e->getMessage());
            return redirect()->back()->withErrors([
                'file' => 'Gagal simpan ke database: ' . $e->getMessage()
            ]);
        }
    }

    public function store(Request $request) 
    {
        // Menambahkan pengaman agar site_code terisi otomatis dari site_id
        $data = $request->all();
        if(!isset($data['site_code'])) {
            $data['site_code'] = $request->site_id;
        }

        Site::create($data);
        return back()->with('success', 'Data Site berhasil ditambahkan!');
    }

    public function update(Request $request, $id) 
    {
        $site = Site::findOrFail($id);
        $site->update($request->all());
        return back()->with('success', 'Data Site berhasil diperbarui!');
    }

    // TAMBAHKAN INI: Method untuk menghapus data
    public function destroy($id)
    {
        $site = Site::findOrFail($id);
        $site->delete();
        return back()->with('success', 'Data Site berhasil dihapus!');
    }
    public function export() 
    {
        return Excel::download(new SitesExport, 'Database_All_Site.xlsx');
    }
    public function show($id)
    {
        // Cukup kembalikan ke halaman utama jika memang tidak ada halaman detail khusus
        return redirect()->route('datasite'); 
    }
}