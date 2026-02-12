<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Site;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CloseTicketExport;
use App\Imports\CloseTicketImport;

class CloseTicketController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->q;

        $tickets = Ticket::with('site')
            ->where('status', 'close')
            ->when($search, function ($q) use ($search) {
                $q->where('site_code', 'like', "%$search%")
                  ->orWhere('nama_site', 'like', "%$search%");
            })
            ->latest()
            ->paginate(20);

        // ambil data site untuk dropdown
        $sites = Site::orderBy('site_code')->get();

        // hitungan untuk badge
        $closeAllCount = Ticket::where('status', 'close')->count();
        $todayCount = Ticket::where('status', 'close')
            ->whereDate('created_at', now()->toDateString())
            ->count();

        return view('close', compact(
            'tickets',
            'sites',
            'search',
            'closeAllCount',
            'todayCount'
        ));
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

        // paksa status close (biar aman)
        $data['status'] = 'close';

        Ticket::create($data);

        return redirect()->back()->with('success', 'Ticket Close berhasil ditambahkan');
    }

    // ======================
    // EXPORT
    // ======================
    public function export()
    {
        return Excel::download(new CloseTicketExport, 'close-ticket.xlsx');
    }

    // ======================
    // IMPORT
    // ======================
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new CloseTicketImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data close ticket berhasil diimport');
    }
}
