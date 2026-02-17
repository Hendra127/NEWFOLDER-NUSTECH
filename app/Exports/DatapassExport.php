<?php

namespace App\Exports;

use App\Models\Datapass;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DatapassExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * Ambil semua data
    */
    public function collection()
    {
        // Gunakan eager loading 'site' agar tidak berat saat mengambil Site ID
        return Datapass::with('site')->get();
    }

    /**
    * Judul kolom di Excel
    */
    public function headings(): array
    {
        return [
            'Site ID',
            'Nama Lokasi',
            'Kabupaten',
            'ADOP',
            'PASS AP1',
            'PASS AP2',
        ];
    }

    /**
    * Mapping data agar sesuai dengan kolom (khususnya untuk mengambil site_id dari relasi)
    */
    public function map($datapass): array
    {
        return [
            $datapass->site->site_id ?? '-', // Mengambil string Site ID dari relasi
            $datapass->nama_lokasi,
            $datapass->kabupaten,
            $datapass->adop,
            $datapass->pass_ap1,
            $datapass->pass_ap2,
        ];
    }
}