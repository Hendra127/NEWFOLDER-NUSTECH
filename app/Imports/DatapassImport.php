<?php

namespace App\Imports;

use App\Models\Datapass;
use App\Models\Site; // Pastikan model Site diimport
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DatapassImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // 1. Cari ID asli di tabel sites berdasarkan string 'site_id' dari Excel
        $site = Site::where('site_id', $row['site_id'])->first();

        // Jika site tidak ditemukan, data ini dilewati (atau bisa disesuaikan logic-nya)
        if (!$site) {
            return null;
        }

        return new Datapass([
            'site_id'     => $site->id, // Menggunakan ID (Foreign Key)
            'nama_lokasi' => $row['nama_lokasi'],
            'kabupaten'   => $row['kabupaten'],
            'adop'        => $row['adop'],
            'pass_ap1'    => $row['pass_ap1'],
            'pass_ap2'    => $row['pass_ap2'],
        ]);
    }
}