<?php

namespace App\Exports;

use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TicketExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Ticket::where('status','open')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Site ID',
            'Nama Site',
            'Provinsi',
            'Kabupaten',
            'Kategori',
            'Tanggal Rekap',
            'Bulan Open',
            'Status',
            'Status Tiket',
            'Durasi',
            'Durasi Akhir',
            'Kendala',
            'Tanggal Close',
            'Bulan Close',
            'Evidence',
            'Detail Problem',
            'Plan Actions',
            'CE',
            'Created At'
        ];
    }
}
