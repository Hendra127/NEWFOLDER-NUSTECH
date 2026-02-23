<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\PMLiberta; // Import model PMLiberta
use Carbon\Carbon;
use App\Models\Message; // Import model Message

class MyDashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil data Tiket Open untuk tabel di dashboard
        $tickets = Ticket::where('status', 'open')
            ->latest()
            ->paginate(10);

        // 2. Hitung Statistik Utama (Ticket)
        $todayCount = Ticket::whereDate('created_at', Carbon::today())->count();
        $totalOpen = Ticket::where('status', 'open')->count();
        
        // 3. Statistik PM (Diambil dari Model PMLiberta)
        
        // Hitung PM BMN: Total yang 'Done' dan Total Keseluruhan
        $pmBmnDone = PMLiberta::where('kategori', 'BMN')
            ->where('status', 'DONE')
            ->count();
        $pmBmnTotal = PMLiberta::where('kategori', 'BMN')
            ->count();

        // Hitung PM SL: Total yang 'Done' dan Total Keseluruhan
        $pmSlDone = PMLiberta::where('kategori', 'SL')
            ->where('status', 'DONE')
            ->count();
        $pmSlTotal = PMLiberta::where('kategori', 'SL')
            ->count();

        // 4. Data untuk Sidebar (Group by Detail Problem)
        // Kita mengambil detail_problem dan nama_site agar list nama site muncul saat diklik
        $sidebarTickets = Ticket::where('status', 'open')
            ->select('detail_problem', 'nama_site') 
            ->get()
            ->groupBy('detail_problem');

        // 5. Kirim semua variabel ke view 'mydashboard'
        return view('mydashboard', compact(
            'tickets', 
            'todayCount', 
            'totalOpen', 
            'pmBmnDone',
            'pmBmnTotal',
            'pmSlDone',
            'pmSlTotal',
            'sidebarTickets'
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
}