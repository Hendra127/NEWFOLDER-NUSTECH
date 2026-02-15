<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Site;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TicketExport;
use App\Imports\TicketImport;
use Carbon\Carbon;

class OpenTicketController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->q;

        // Mengambil ticket dengan status 'open' dan relasi ke site
        $tickets = Ticket::with('site')
            ->where('status', 'open')
            ->when($search, function ($q) use ($search) {
                $q->where('site_code', 'like', "%$search%")
                  ->orWhere('nama_site', 'like', "%$search%")
                  ->orWhere('kabupaten', 'like', "%$search%");
            })
            ->latest()
            ->paginate(20);

        // Ambil data site untuk dropdown di Modal Tambah
        $sites = Site::orderBy('site_id', 'asc')->get();

        // Hitung total tiket hari ini
        $today = Ticket::whereDate('created_at', Carbon::today())->count();

        return view('open', compact('tickets', 'sites', 'search', 'today'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'site_id'        => 'required', // ID Primary Key dari tabel sites
            'site_code'      => 'required|string',
            'nama_site'      => 'required|string',
            'provinsi'       => 'required|string',
            'kabupaten'      => 'required|string',
            'kategori'       => 'required|string',
            'tanggal_rekap'  => 'nullable|date',
            'durasi'         => 'nullable|numeric',
            'durasi_akhir'   => 'nullable|numeric',
            'kendala'        => 'nullable|string',
            'detail_problem' => 'required|string',
            'status'         => 'required|string',
        ]);

        // Otomatisasi nama bulan berdasarkan tanggal rekap
        if ($request->filled('tanggal_rekap')) {
            $data['bulan_open'] = Carbon::parse($request->tanggal_rekap)->format('F');
        }

        Ticket::create($data);

        return redirect()->back()->with('success', 'Ticket berhasil ditambahkan secara permanen.');
    }

    public function export()
    {
        return Excel::download(new TicketExport, 'open-ticket.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new TicketImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data ticket berhasil diimport');
    }
}