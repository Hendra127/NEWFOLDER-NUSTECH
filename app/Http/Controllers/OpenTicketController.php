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
    // Mengambil semua input untuk filter & search
    $search = $request->q;
    $status_tiket = $request->status_tiket;
    $kategori = $request->kategori;
    $provinsi = $request->provinsi;

    // Query dasar
    $tickets = Ticket::with('site')
        ->where('status', 'open') // Tetap memfilter status utama 'open'
        
        // Filter Search (Site Code, Nama, Kabupaten)
        ->when($search, function ($q) use ($search) {
            $q->where(function($query) use ($search) {
                $query->where('site_code', 'like', "%$search%")
                      ->orWhere('nama_site', 'like', "%$search%")
                      ->orWhere('kabupaten', 'like', "%$search%");
            });
        })

        // Filter Status Tiket (dari Modal)
        ->when($status_tiket, function ($q) use ($status_tiket) {
            return $q->where('status_tiket', $status_tiket);
        })

        // Filter Kategori (dari Modal)
        ->when($kategori, function ($q) use ($kategori) {
            return $q->where('kategori', $kategori);
        })

        // Filter Provinsi (dari Modal)
        ->when($provinsi, function ($q) use ($provinsi) {
            return $q->where('provinsi', 'like', "%$provinsi%");
        })

        ->latest()
        ->paginate(20)
        ->withQueryString(); // Sangat penting agar filter tidak hilang saat pindah halaman (pagination)

    $sites = Site::orderBy('site_id', 'asc')->get();
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
            'plan_actions'    => 'nullable|string',
            'ce'             => 'nullable|string',
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori'       => 'required',
            'tanggal_rekap'  => 'required|date',
            'kendala'        => 'required',
            'detail_problem' => 'required',
            'plan_actions'    => 'required',
            'ce'             => 'required',
        ]);

        $ticket = Ticket::findOrFail($id);
        
        // Update data
        $ticket->kategori       = $request->kategori;
        $ticket->tanggal_rekap  = $request->tanggal_rekap;
        $ticket->kendala        = $request->kendala;
        $ticket->detail_problem = $request->detail_problem;
        $ticket->plan_actions    = $request->plan_actions;
        $ticket->ce             = $request->ce;
        
        // Update bulan_open otomatis
        $ticket->bulan_open     = \Carbon\Carbon::parse($request->tanggal_rekap)->format('F');

        $ticket->save();

        return redirect()->back()->with('success', 'Tiket ' . $ticket->site_code . ' berhasil diupdate!');
    }

    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return redirect()->back()->with('success', 'Tiket berhasil dihapus!');
    }
    // Di dalam Controller Anda
    public function closeTicket(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        // 1. Ambil waktu sekarang
        $now = \Carbon\Carbon::now();
        $tanggalOpen = \Carbon\Carbon::parse($ticket->tanggal_rekap);

        // 2. Hitung durasi akhir (selisih hari dari open sampai hari ini)
        $durasi = $tanggalOpen->diffInDays($now);

        // 3. Update status menjadi 'closed' dan isi tanggal_close
        $ticket->update([
            'status'        => 'closed',      // Ubah status ke closed
            'tanggal_close' => $now->toDateString(), // Isi tanggal hari ini (YYYY-MM-DD)
            'durasi'        => $durasi,       // Update durasi final
            'bulan_close'   => $now->format('F'), // Opsional: Isi nama bulan close
        ]);

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Tiket ' . $ticket->nama_site . ' berhasil dipindahkan ke Close Ticket.');
    }
}