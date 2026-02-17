<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanPM extends Model
{
    protected $table = 'laporan_pm';

    protected $fillable = [
        'tanggal_submit',
        'site_id',
        'pm_bulan',
        'teknisi',
        'status',
    ];
}