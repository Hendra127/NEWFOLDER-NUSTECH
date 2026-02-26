<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    $shifts = [
        ['kode' => 'P', 'nama' => 'Pagi', 'jam_mulai' => '07:30:00', 'jam_selesai' => '15:30:00'],
        ['kode' => 'S', 'nama' => 'Siang', 'jam_mulai' => '15:30:00', 'jam_selesai' => '23:30:00'],
        ['kode' => 'M', 'nama' => 'Malam', 'jam_mulai' => '23:30:00', 'jam_selesai' => '07:30:00'],
        ['kode' => 'OFF', 'nama' => 'Libur', 'jam_mulai' => '00:00:00', 'jam_selesai' => '00:00:00'],
    ];

    foreach ($shifts as $s) {
        // Menggunakan updateOrCreate agar tidak terjadi duplikat jika dijalankan berkali-kali
        \App\Models\Shift::updateOrCreate(
            ['kode' => $s['kode']], // Unik berdasarkan kode
            [
                'nama' => $s['nama'],
                'jam_mulai' => $s['jam_mulai'],
                'jam_selesai' => $s['jam_selesai']
            ]
        );
    }
}
}
