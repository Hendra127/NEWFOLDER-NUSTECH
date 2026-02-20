<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanPM;
use App\Models\Site;

class LaporanPMController extends Controller
{
    public function index(Request $request)
    {
        $sites = Site::orderBy('sitename')->get();

        $query = LaporanPM::query()->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('site_id', 'like', "%$search%")
                    ->orWhere('teknisi', 'like', "%$search%")
                    ->orWhere('status_laporan', 'like', "%$search%")
                    ->orWhere('pm_bulan', 'like', "%$search%");
            });
        }

        $data = $query->get();

        return view('laporanpm', compact('sites', 'data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_submit' => 'required|date',
            'site_id'        => 'required|string',
            'pm_bulan'       => 'required|string',
            'teknisi'        => 'required|string|max:100',
            'status'         => 'required|string', // Ubah dari status_laporan ke status
            'masalah_kendala'        => 'nullable|string', // Pastikan divalidasi
            // ... field lainnya
        ]);

        $site = Site::where('site_id', $request->site_id)->first();
        if (!$site) {
            return redirect()->back()->with('error', 'Site tidak ditemukan!')->withInput();
        }

        LaporanPM::create([
            'tanggal_submit'  => $request->tanggal_submit,
            'site_id'         => $request->site_id,
            'pm_bulan'        => $request->pm_bulan,
            'teknisi'         => $request->teknisi,
            'lokasi_site'     => $request->lokasi_site,
            'kabupaten_kota'  => $request->kabupaten_kota,
            'provinsi'        => $request->provinsi,
            'laporan_ba_pm'   => $request->laporan_ba_pm,
            'masalah_kendala' => $request->masalah_kendala, // Ambil dari name="kendala" di blade
            'action'          => $request->action,
            'ket_tambahan'    => $request->ket_tambahan,
            'status_laporan'  => $request->status, // Map ke kolom status_laporan
            'status'          => $request->status, // Map ke kolom status
        ]);

        return redirect()->route('laporanpm')->with('success', 'Data berhasil disimpan!');
    }
    public function update(Request $request, $id)
{
    $request->validate([
        'tanggal_submit' => 'required|date',
        'teknisi' => 'required|string|max:100',
        'status' => 'required',
    ]);

    $data = LaporanPM::findOrFail($id);
    $data->update([
        'tanggal_submit'  => $request->tanggal_submit,
        'teknisi'         => $request->teknisi,
        'masalah_kendala' => $request->masalah_kendala,
        'action'          => $request->action,
        'ket_tambahan'    => $request->ket_tambahan,
        'status'          => $request->status,
        'status_laporan'  => $request->status, // Samakan jika kolomnya berbeda
    ]);

    return redirect()->back()->with('success', 'Data berhasil diperbarui!');
}

public function destroy($id)
{
    $data = LaporanPM::findOrFail($id);
    
    // Opsional: Hapus file laporan jika ada di storage
    if ($data->laporan_ba_pm) {
        // Storage::delete('path/to/file/' . $data->laporan_ba_pm);
    }

    $data->delete();

    return redirect()->back()->with('success', 'Data berhasil dihapus!');
}
}


