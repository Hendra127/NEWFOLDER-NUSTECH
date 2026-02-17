<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Site;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CloseTicketExport;
use App\Imports\CloseTicketImport;
use Carbon\Carbon;

class CloseTicketController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->q;
        $kategori = $request->kategori;
        $tgl_mulai = $request->tgl_mulai;
        $tgl_selesai = $request->tgl_selesai;

        // Inisialisasi Query dengan status 'closed'
        $query = Ticket::with('site')->where('status', 'closed');

        // 1. Filter Pencarian (Site Code, Nama Site, atau CE)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('site_code', 'like', "%$search%")
                  ->orWhere('nama_site', 'like', "%$search%")
                  ->orWhere('ce', 'like', "%$search%");
            });
        }

        // 2. Filter Kategori (Dari Modal)
        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        // 3. Filter Range Tanggal (Berdasarkan tanggal_close)
        if ($tgl_mulai && $tgl_selesai) {
            $query->whereBetween('tanggal_close', [$tgl_mulai, $tgl_selesai]);
        }

        // Ambil data dengan pagination dan pertahankan parameter query di URL
        $tickets = $query->latest('updated_at')->paginate(20)->withQueryString();

        // Hitungan untuk badge
        $closeAllCount = Ticket::where('status', 'closed')->count();
        $todayCount = Ticket::where('status', 'closed')
            ->whereDate('updated_at', Carbon::today())
            ->count();

        // Data site untuk modal tambah
        $sites = Site::orderBy('site_code')->get();

        return view('close', compact('tickets', 'sites', 'search', 'closeAllCount', 'todayCount'));
    }

    public function store(Request $request)
    {
        // Validasi menyertakan plan_actions dan ce agar tidak gagal simpan
        $data = $request->validate([
            'site_id'        => 'required|exists:sites,id',
            'site_code'      => 'required|string',
            'nama_site'      => 'required|string',
            'provinsi'       => 'required|string',
            'kabupaten'      => 'required|string',
            'kategori'       => 'required|string',
            'tanggal_rekap'  => 'nullable|date',
            'durasi'         => 'nullable|numeric',
            'kendala'        => 'nullable|string',
            'detail_problem' => 'required|string',
            'plan_actions'   => 'required|string', // Tambahkan ini
            'ce'             => 'required|string',   // Tambahkan ini
        ]);

        // Tambahkan atribut otomatis
        $data['status'] = 'closed'; // Konsisten gunakan 'closed' sesuai database
        $data['tanggal_close'] = Carbon::now(); // Otomatis isi tanggal close hari ini

        Ticket::create($data);

        return redirect()->back()->with('success', 'Ticket Close berhasil ditambahkan');
    }

    public function export(Request $request)
    {
        // Kita kirimkan semua parameter request (q, kategori, tgl_mulai, tgl_selesai) 
        // ke dalam class Export agar hasil download sama dengan yang tampil di layar
        return Excel::download(new CloseTicketExport($request), 'close-ticket.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new CloseTicketImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data close ticket berhasil diimport');
    }
}