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
        $user = \App\Models\User::firstOrCreate(
            ['name' => $namaPetugas],
            [
                'email' => str_replace(' ', '.', strtolower($namaPetugas)) . '@nustech.co.id',
                'password' => bcrypt('Masuk123*#'),
                'is_admin' => 1,
            ]
        );

        // JIKA KODE ADALAH 'OFF', HAPUS DATA JADWAL (KARENA LIBUR)
        if ($request->shift_kode === 'OFF') {
            \App\Models\JadwalPiket::where('user_id', $user->id)
                ->where('tanggal', $request->tanggal)
                ->delete();

            return response()->json(['status' => 'success', 'message' => 'Jadwal dikosongkan (OFF)']);
        }

        // CARI SHIFT BERDASARKAN KODE
        $shift = \App\Models\Shift::where('kode', $request->shift_kode)->first();

        // VALIDASI JIKA SHIFT TIDAK DITEMUKAN DI DB
        if (!$shift) {
            return response()->json(['status' => 'error', 'message' => 'Master data Shift ' . $request->shift_kode . ' tidak ditemukan!'], 404);
        }

        \App\Models\JadwalPiket::updateOrCreate(
            ['user_id' => $user->id, 'tanggal' => $request->tanggal],
            ['shift_id' => $shift->id, 'status' => 'aktif']
        );

        return response()->json(['status' => 'success', 'message' => 'Berhasil update shift.']);

    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'Gagal: ' . $e->getMessage()], 500);
    }
}
}