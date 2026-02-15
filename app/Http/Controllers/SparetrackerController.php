<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sparetracker;
use App\Models\Datasite;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LogTrackerImport;
use App\Exports\LogTrackerExport;

class SparetrackerController extends Controller
{
    public function index(Request $request)
    {
        $query = Sparetracker::query();

        if ($request->search) {
            $searchTerm = trim($request->search);
            $query->where(function ($q) use ($searchTerm) {
                $q->where('sn', 'like', "%{$searchTerm}%")
                  ->orWhere('nama_perangkat', 'like', "%{$searchTerm}%");
            });
        }

        $data = $query->latest()->paginate(20);

        return view('sparetracker', compact('data'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new LogTrackerImport, $request->file('file'));

        return back()->with('success', 'Data berhasil diimpor.');
    }

    public function export()
    {
        return Excel::download(new LogTrackerExport, 'logtracker.xlsx');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sn' => 'required|string|max:255',
            'nama_perangkat' => 'nullable|string|max:255',
            'jenis' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'kondisi' => 'nullable|string|max:255',
            'pengadaan_by' => 'nullable|string|max:255',
            'lokasi_asal' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'bulan_masuk' => 'nullable|string|max:255',
            'tanggal_masuk' => 'nullable|date',
            'status_penggunaan_sparepart' => 'nullable|string|max:255',
            'lokasi_realtime' => 'nullable|string|max:255',
            'kabupaten' => 'nullable|string|max:255',
            'bulan_keluar' => 'nullable|string|max:255',
            'tanggal_keluar' => 'nullable|date',
            'layanan_ai' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $spare = Sparetracker::create($validated);

        $this->syncDatasiteSN($spare);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
    }

    public function update(Request $request)
    {
        $data = Sparetracker::findOrFail($request->id);

        $validated = $request->validate([
            'sn' => 'required|string|max:255',
            'nama_perangkat' => 'nullable|string|max:255',
            'jenis' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'kondisi' => 'nullable|string|max:255',
            'pengadaan_by' => 'nullable|string|max:255',
            'lokasi_asal' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'bulan_masuk' => 'nullable|string|max:255',
            'tanggal_masuk' => 'nullable|date',
            'status_penggunaan_sparepart' => 'nullable|string|max:255',
            'lokasi_realtime' => 'nullable|string|max:255',
            'kabupaten' => 'nullable|string|max:255',
            'bulan_keluar' => 'nullable|string|max:255',
            'tanggal_keluar' => 'nullable|date',
            'layanan_ai' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $data->update($validated);

        $this->syncDatasiteSN($data);

        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $data = Sparetracker::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }

    /**
     * Sinkron SN ke tabel datasite (berdasarkan lokasi_realtime = sitename)
     */
    private function syncDatasiteSN(Sparetracker $spare)
    {
        if (!$spare->lokasi_realtime) {
            return;
        }

        $datasite = Datasite::where('sitename', $spare->lokasi_realtime)->first();

        if (!$datasite) {
            return;
        }

        $jenis = strtoupper(trim((string) $spare->jenis));

        switch ($jenis) {
            case 'MODEM':
                $datasite->sn_modem = $spare->sn;
                break;

            case 'ROUTER':
                $datasite->sn_router = $spare->sn;
                break;

            case 'SWITCH':
                $datasite->sn_switch = $spare->sn;
                break;

            case 'AP1':
            case 'ACCESS POINT 1':
            case 'AP 1':
                $datasite->sn_ap1 = $spare->sn;
                break;

            case 'AP2':
            case 'ACCESS POINT 2':
            case 'AP 2':
                $datasite->sn_ap2 = $spare->sn;
                break;

            case 'STAVOL':
            case 'STABILIZER':
                $datasite->sn_stabilizer = $spare->sn;
                break;

            default:
                return;
        }

        $datasite->save();
    }
}