<?php

namespace App\Imports;

use App\Models\JadwalPiket;
use App\Models\User;
use App\Models\Shift;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PiketImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // 1. Lewati jika baris kosong (berdasarkan file CSV Anda yang memiliki banyak koma kosong)
        if (empty($row['nama']) || empty($row['tanggal'])) {
            return null;
        }

        // 2. Buat User secara otomatis jika tidak ada di database
        // Kita gunakan 'firstOrCreate' agar tidak duplikat
        $user = User::firstOrCreate(
            ['name' => $row['nama']], // Cari berdasarkan nama
            [
                'email' => Str::slug($row['nama']) . '@piket.com', // Email otomatis (unik)
                'password' => Hash::make('password123'), // Password default
            ]
        );

        // 3. Cari ID Shift (P, S, M, OFF)
        $shift = Shift::where('kode', $row['shift'])->first();

        if ($shift) {
            return new JadwalPiket([
                'user_id'  => $user->id,
                'shift_id' => $shift->id,
                'tanggal'  => $row['tanggal'], // Mengambil tanggal dari file 
                'status'   => 'aktif',
            ]);
        }
        
        return null;
    }
}