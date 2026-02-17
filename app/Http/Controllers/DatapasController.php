<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Datapass;
use App\Models\Site;
use App\Exports\DatapassExport;
use App\Imports\DatapassImport;
use Maatwebsite\Excel\Facades\Excel;

class DatapasController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        
        $datapass = Datapass::with('site')
            ->when($search, function($query) use ($search) {
                $query->where(function($q) use ($search) { // Bungkus group where agar search tidak kacau
                    $q->where('nama_lokasi', 'like', "%{$search}%")
                    ->orWhere('kabupaten', 'like', "%{$search}%")
                    ->orWhereHas('site', function($sq) use ($search) {
                        $sq->where('site_id', 'like', "%{$search}%");
                    });
                });
            })
            ->get(); // <--- Pakai get() untuk ambil SEMUA data

        $sites = Site::all();

        return view('datapas', compact('datapass', 'sites'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'site_id' => 'required',
            'nama_lokasi' => 'required',
            'kabupaten' => 'required',
            'adop' => 'required',
            'pass_ap1' => 'required',
            'pass_ap2' => 'required',
        ]);

        Datapass::create($request->all());

        return back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function export() 
    {
        return Excel::download(new DatapassExport, 'Data_Password_Export.xlsx');
    }

    public function import(Request $request) 
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        try {
            Excel::import(new DatapassImport, $request->file('file'));
            return back()->with('success', 'Data berhasil diimport!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'site_id' => 'required',
            'nama_lokasi' => 'required',
            'kabupaten' => 'required',
            'adop' => 'required',
            'pass_ap1' => 'required',
            'pass_ap2' => 'required',
        ]);

        $data = Datapass::findOrFail($id);
        $data->update($request->all());

        return back()->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $data = Datapass::findOrFail($id);
        $data->delete();

        return back()->with('success', 'Data berhasil dihapus!');
    }
}