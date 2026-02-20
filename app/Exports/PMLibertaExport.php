<?php

namespace App\Exports;

use App\Models\PMLiberta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PMLibertaExport implements FromCollection, WithHeadings, WithMapping
{
    protected $search;

    // Menangkap filter pencarian dari controller
    public function __construct($search = null)
    {
        $this->search = $search;
    }

    public function collection()
    {
        return PMLiberta::when($this->search, function($query) {
            $query->where('site_id', 'like', '%' . $this->search . '%')
                  ->orWhere('nama_lokasi', 'like', '%' . $this->search . '%');
        })->get();
    }

    // Header Tabel di Excel
    public function headings(): array
    {
        return [
            'SITE ID',
            'NAMA LOKASI',
            'PROVINSI',
            'KABUPATEN / KOTA',
            'PIC CE',
            'MONTH',
            'DATE',
            'STATUS',
            'WEEK',
            'KATEGORI',
        ];
    }

    // Mapping kolom agar urutannya sesuai dengan database
    public function map($row): array
    {
        return [
            $row->site_id,
            $row->nama_lokasi,
            $row->provinsi,
            $row->kabupaten,
            $row->pic_ce,
            $row->month,
            $row->date,
            $row->status,
            $row->week,
            $row->kategori,
        ];
    }
}