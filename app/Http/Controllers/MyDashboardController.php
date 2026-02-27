<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\PMLiberta; // Import model PMLiberta
use Carbon\Carbon;
use App\Models\Message; // Import model Message
use App\Models\JadwalPiket; // Import model Piket

class MyDashboardController extends Controller
{
    public function index()
{
    // Ambil waktu sekarang (WITA)
    $now = Carbon::now();
    $today = $now->format('Y-m-d');
    $currentTime = $now->format('H:i');

    // 1. Ambil data Tiket Open untuk tabel di dashboard
    $tickets = Ticket::where('status', 'open')
        ->latest()
        ->paginate(10);

    // 2. Hitung Statistik Utama (Ticket)
    $todayCount = Ticket::whereDate('created_at', $today)->count();
    $totalOpen = Ticket::where('status', 'open')->count();
    
    // 3. Statistik PM (Diambil dari Model PMLiberta)
    $pmBmnDone = PMLiberta::where('kategori', 'BMN')->where('status', 'DONE')->count();
    $pmBmnTotal = PMLiberta::where('kategori', 'BMN')->count();

    $pmSlDone = PMLiberta::where('kategori', 'SL')->where('status', 'DONE')->count();
    $pmSlTotal = PMLiberta::where('kategori', 'SL')->count();

    // 4. Data untuk Sidebar (Group by Detail Problem)
    $sidebarTickets = Ticket::where('status', 'open')
        ->select('detail_problem', 'nama_site') 
        ->get()
        ->groupBy('detail_problem');

    // ==========================================================
    // 5. LOGIKA OTOMATIS SHIFT BERDASARKAN JAM (FIXED)
    // ==========================================================
    
    // Tentukan Kode Shift Berdasarkan Jam Sekarang
    $currentShiftCode = match (true) {
        $currentTime >= '07:30' && $currentTime < '15:30' => 'P', // Pagi
        $currentTime >= '15:30' && $currentTime < '23:30' => 'S', // Siang
        ($currentTime >= '23:30' || $currentTime < '07:30') => 'M', // Malam (Sesuai Permintaan)
        default => 'OFF',
    };

    // Ambil Personil yang piket HANYA pada shift yang sedang aktif saat ini
    $piketHariIni = \App\Models\JadwalPiket::with(['user', 'shift'])
        ->whereDate('tanggal', $today)
        ->whereHas('shift', function($query) use ($currentShiftCode) {
            $query->where('kode', $currentShiftCode);
        })
        ->get();

    // Tentukan Teks Jam Kerja untuk ditampilkan di Header Dashboard
    $jamTeks = match($currentShiftCode) {
        'P' => '07:30 - 15:30',
        'S' => '15:30 - 23:30',
        'M' => '23:30 - 07:30', // Jam shift malam diperbaiki
        default => 'Libur'
    };

    $shiftInfo = $now->translatedFormat('d M') . " " . $jamTeks . " WITA";

    // 6. Kirim semua variabel ke view 'mydashboard'
    return view('mydashboard', compact(
        'tickets', 
        'todayCount', 
        'totalOpen', 
        'pmBmnDone',
        'pmBmnTotal',
        'pmSlDone',
        'pmSlTotal',
        'sidebarTickets',
        'piketHariIni',
        'shiftInfo'
    ));
}
    public function getDetail($site_code)
    {
        try {
            // Tambahkan with('site') untuk mengambil data dari tabel sites
            $ticket = Ticket::with('site')->where('site_code', $site_code)->first();

            if (!$ticket) {
                return response()->json(['error' => 'Data tidak ditemukan'], 404);
            }
            
            return response()->json([
                'nama_site' => $ticket->nama_site,
                'site_id'   => $ticket->site_code,
                'kategori'  => $ticket->kategori ?? '-',
                'provinsi'  => $ticket->provinsi ?? '-',
                'kabupaten' => $ticket->kabupaten ?? '-',
                'sumber_listrik' => $ticket->sumber_listrik ?? '-',
                'durasi'    => $ticket->tanggal_rekap ? Carbon::parse($ticket->tanggal_rekap)->diffInDays(now()) : 0,
                'detail_problem' => $ticket->detail_problem ?? '-',
                'ce'        => $ticket->ce ?? '-',
                
                // AMBIL DARI RELASI SITE
                'latitude'  => $ticket->site->latitude ?? 0, 
                'longitude' => $ticket->site->longitude ?? 0
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
public function fetchMessages() {
    $currentUserId = auth()->id();
    $currentIp = request()->ip(); // Menggunakan IP sebagai penanda Guest

    $messages = \App\Models\Message::with(['user', 'parent.user'])
        ->latest()
        ->take(50)
        ->get()
        ->reverse()
        ->map(function ($msg) use ($currentUserId) {
            $msg->is_me = auth()->check() ? ($msg->user_id === $currentUserId) : is_null($msg->user_id);
            
            // Tambahkan baris ini untuk mendeteksi apakah pengirim adalah admin
            // Kita cek dari relasi user-nya
            $msg->is_sender_admin = $msg->user ? (bool)$msg->user->is_admin : (bool)$msg->is_admin;
            
            return $msg;
        })
        ->values();

    return response()->json($messages);
}
public function storeMessage(Request $request)
{
    $request->validate([
        'message' => 'required|string',
        'guest_name' => 'nullable|string|max:50',
        'parent_id' => 'nullable|exists:messages,id'
    ]);

    $user = auth()->user();

    $chat = \App\Models\Message::create([
        'user_id'    => auth()->check() ? auth()->id() : null,
        'guest_name' => !auth()->check() ? $request->guest_name : null,
        'message'    => $request->message,
        'parent_id'  => $request->parent_id,
        // Kolom is_admin di database (status pesan)
        'is_admin'   => auth()->check() ? ($user->is_admin ?? false) : false,
    ]);

    $chat->load(['user', 'parent.user']);

    // Tambahkan atribut tambahan agar JS bisa langsung baca label (ADMIN)
    $chat->is_sender_admin = $user ? (bool)$user->is_admin : false;

    return response()->json($chat);
}
public function getFilteredTickets(Request $request)
{
    try {
        $type = $request->get('type');
        $label = "Ticket List";
        $tickets = [];

        if ($type == 'today' || $type == 'all_open') {
            $query = \DB::table('tickets');
            if ($type == 'today') {
                $query->whereDate('created_at', now());
                $label = "Tickets Today";
            } else {
                $query->where('status', 'open');
                $label = "All Open Tickets";
            }
            
            $tickets = $query->get()->map(function($item) {
                return [
                    'nama_site' => $item->nama_site,
                    'site_code' => $item->site_code,
                    'status'    => strtoupper($item->status),
                    'display_date' => $item->durasi . " Hari"
                ];
            });
        } 
        elseif ($type == 'pm_bmn' || $type == 'pm_sl') {
            $kategori = ($type == 'pm_bmn') ? 'BMN' : 'SL';
            $label = "PM " . $kategori . " Done";

            $tickets = \DB::table('pmliberta')
                ->where('kategori', $kategori)
                ->where('status', 'DONE')
                ->get()
                ->map(function($item) {
                    return [
                        'nama_site' => $item->nama_lokasi ?? '-', // Mengambil dari field nama_lokasi
                        'site_code' => $item->site_id ?? '-',
                        'status'    => 'DONE',
                        'display_date' => $item->date ?? '-' // Mengambil nilai field 'date' asli dari DB
                    ];
                });
        }

        return response()->json([
            'success' => true,
            'tickets' => $tickets,
            'type_label' => $label
        ]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}
}