<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Site;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TicketExport;
use App\Imports\TicketImport;

class OpenTicketController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->q;

        $tickets = Ticket::with('site')
            ->where('status', 'open')
            ->when($search, function ($q) use ($search) {
                $q->where('site_code', 'like', "%$search%")
                  ->orWhere('nama_site', 'like', "%$search%");
            })
            ->latest()
            ->paginate(20);

        // 🔥 AMBIL DATA SITE (UNTUK DROPDOWN)
        $sites = Site::orderBy('site_code')->get();

        return view('open', compact('tickets', 'sites', 'search'));
    }

    // ======================
    // STORE DATA
    // ======================
    public function store(Request $request)
    {
        $data = $request->validate([
            'site_id'        => 'required|exists:sites,id',
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

        Ticket::create($data);

        return redirect()->back()->with('success', 'Ticket berhasil ditambahkan');
    }

    // ======================
    // EXPORT
    // ======================
    public function export()
    {
        return Excel::download(new TicketExport, 'open-ticket.xlsx');
    }

    // ======================
    // IMPORT
    // ======================
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new TicketImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data ticket berhasil diimport');
    }
}
