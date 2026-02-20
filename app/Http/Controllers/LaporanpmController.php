<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanPM;
use App\Models\Site;

class LaporanPMController extends Controller
{
    public function index(Request $request)
    {
        // ambil semua site buat dropdown modal
        $sites = Site::orderBy('sitename')->get();

        // query laporan pm
        $query = LaporanPM::query()
            ->orderBy('created_at', 'desc');

        // fitur search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('site_id', 'like', "%$search%")
                  ->orWhere('teknisi', 'like', "%$search%")
                  ->orWhere('status', 'like', "%$search%")
                  ->orWhere('pm_bulan', 'like', "%$search%");
            });
        }

        // ambil datanya
        $data = $query->get();

        return view('laporanpm', compact('sites', 'data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_submit' => 'required|date',
            'site_id' => 'required|string',
            'pm_bulan' => 'required|string|max:2',
            'teknisi' => 'required|string|max:100',
            'status' => 'required|string|max:50',
        ]);

        // ambil data site dari tabel sites (biar lokasi, provinsi, kabupaten bisa otomatis masuk)
        $site = Site::where('site_id', $request->site_id)->first();

        if (!$site) {
            return redirect()->back()->with('error', 'Site tidak ditemukan!')->withInput();
        }

        LaporanPM::create([
            'tanggal_submit' => $request->tanggal_submit,
            'site_id' => $request->site_id,
            'pm_bulan' => $request->pm_bulan,
            'teknisi' => $request->teknisi,
            'status' => $request->status,

            // OPTIONAL: kalau kolom ini ada di tabel laporan_pm
            // kalau belum ada, hapus 3 baris ini
            'lokasi_site' => $site->site_name,
            'kabupaten_kota' => $site->kabupaten ?? $site->kabupaten_kota ?? null,
            'provinsi' => $site->provinsi ?? null,
        ]);

        return redirect()->route('laporanpm.index')->with('success', 'Data berhasil disimpan!');
    }
}