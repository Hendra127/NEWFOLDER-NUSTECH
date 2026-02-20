<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PMLiberta extends Model
{
    // Arahkan model ini ke tabel pm_reports sesuai gambar ERD
    protected $table = 'pmliberta';

    protected $fillable = [
        'site_id', 
        'nama_lokasi', 
        'provinsi', 
        'kabupaten', 
        'pic_ce', 
        'month', 
        'date', 
        'status', 
        'week', 
        'kategori',
        'durasi'
    ];

    // Relasi ke Model Site
    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }
}