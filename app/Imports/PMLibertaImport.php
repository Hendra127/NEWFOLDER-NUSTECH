<?php

namespace App\Imports;

use App\Models\PMLiberta;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date; // Tambahkan ini

class PMLibertaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Fungsi untuk menangani konversi tanggal Excel
        $tanggalTerformat = null;
        if (isset($row['date'])) {
            if (is_numeric($row['date'])) {
                // Jika berupa angka serial Excel (seperti 45699)
                $tanggalTerformat = Date::excelToDateTimeObject($row['date'])->format('Y-m-d');
            } else {
                // Jika sudah berupa string tanggal (seperti 16/07/2025)
                // Kita coba parse agar formatnya masuk ke DB sebagai Y-m-d
                $tanggalTerformat = date('Y-m-d', strtotime(str_replace('/', '-', $row['date'])));
            }
        }

        return new PMLiberta([
            'site_id'     => $row['site_id'],
            'nama_lokasi' => $row['nama_lokasi'],
            'provinsi'    => $row['provinsi'],
            'kabupaten'   => $row['kabupaten_kota'],
            'pic_ce'      => $row['pic_ce'],
            'month'       => $row['month'],
            'date'        => $tanggalTerformat, // Sekarang tersimpan sebagai '2025-07-16'
            'status'      => $row['status'],
            'week'        => $row['week'],
            'kategori'    => $row['kategori'],
        ]);
    }
}