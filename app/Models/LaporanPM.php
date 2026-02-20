<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanPM extends Model
{
    protected $table = 'laporan_pm';

    protected $fillable = [
        'tanggal_submit', 'site_id', 'lokasi_site', 'kabupaten_kota', 
        'provinsi', 'pm_bulan', 'laporan_ba_pm', 'masalah_kendala', 
        'action', 'ket_tambahan', 'status_laporan', 'teknisi', 'status'
    ];

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', 'site_id');
    }
}