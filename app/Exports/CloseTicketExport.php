<?php

namespace App\Exports;

use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CloseTicketExport implements FromQuery, WithHeadings
{
    protected $request;

    // Menangkap request dari controller
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function query()
    {
        // Filter utama: HANYA yang statusnya closed
        $query = Ticket::query()->where('status', 'closed');

        // Opsional: Jika ingin hasil download mengikuti filter yang sedang dipilih user
        if ($this->request->has('q')) {
            $query->where('site_code', 'like', '%' . $this->request->q . '%');
        }
        
        if ($this->request->filled('tgl_mulai')) {
            $query->whereBetween('tanggal_close', [$this->request->tgl_mulai, $this->request->tgl_selesai]);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Site Code',
            'Site ID',
            'Nama Site',
            'Kategori',
            'Tanggal Open',
            'Tanggal Close',
            'Durasi',
            'Status',
            'CE'
        ];
    }
}