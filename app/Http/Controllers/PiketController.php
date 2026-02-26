<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalPiket;
use App\Models\Shift;
use Carbon\Carbon;

class PiketController extends Controller
{
    public function index(Request $request)
{
    // 1. Tangkap bulan dan tahun dari URL, atau gunakan bulan ini sebagai default
    $month = $request->get('month', date('m'));
    $year = $request->get('year', date('Y'));

    // 2. Buat objek Carbon berdasarkan filter tersebut
    $selectedDate = \Carbon\Carbon::createFromDate($year, $month, 1);
    
    $jumlahHari = $selectedDate->daysInMonth;
    $bulanSekarang = $selectedDate->translatedFormat('F');
    $tahunSekarang = $selectedDate->year;

    // 3. Daftar nama statis
    $daftarNama = [
        'Raden Kukuh Ridho Ahadi', 'Hendra Hadi Pratama', 'Andri Pratama',
        'Muhammad Azul', 'Lalu Taufiq Wijaya', 'Aditia Marandika Rachman', 'IWAN VANI'
    ];

    // 4. Ambil data piket berdasarkan bulan & tahun yang dipilih
    $dataPiket = \App\Models\JadwalPiket::whereMonth('tanggal', $month)
                    ->whereYear('tanggal', $year)
                    ->get();

    return view('jadwalpiket', compact('daftarNama', 'dataPiket', 'jumlahHari', 'bulanSekarang', 'tahunSekarang', 'month', 'year'));
}
    public function updateShift(Request $request)
{
    try {
        $namaPetugas = trim($request->nama);

        // 1. Cek atau Buat User Baru
        $user = \App\Models\User::firstOrCreate(
            ['name' => $namaPetugas],
            [
                'email' => str_replace(' ', '.', strtolower($namaPetugas)) . '@nustech.co.id',
                'password' => bcrypt('Masuk123*#'),
                'is_admin' => 1, // SET SEBAGAI ADMIN SESUAI PERMINTAAN
            ]
        );
        
        // 2. Cari ID Shift berdasarkan kode (M, S, P)
        $shift = \App\Models\Shift::where('kode', $request->shift_kode)->first();

        // 3. Simpan ke Tabel jadwal_piket (Sesuai model Anda)
        \App\Models\JadwalPiket::updateOrCreate(
            [
                'user_id' => $user->id,
                'tanggal' => $request->tanggal,
            ],
            [
                'shift_id' => $shift ? $shift->id : null,
                'status'   => 'aktif'
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil! User ' . $namaPetugas . ' diset sebagai Admin.'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error', 
            'message' => 'Gagal simpan: ' . $e->getMessage()
        ], 500);
    }
}
}