<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'site_id',
        'site_code',
        'kategori','status','durasi','kendala','detail_problem','nama_site',
                'provinsi',
                'kabupaten',
                'tanggal_rekap',
                'bulan_open',
                'status_tiket',
                'tanggal_close',
                'bulan_close',
                'evidence',
                'plan_actions',
                'ce',
                'durasi_akhir',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
