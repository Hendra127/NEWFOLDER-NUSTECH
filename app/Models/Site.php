<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = [
        'site_id',
        'sitename',
        'tipe',
        'batch',
        'latitude',
        'longitude',
        'provinsi',
        'kab',
        'kecamatan',
        'kelurahan',
        'alamat_lokasi',
        'nama_pic',
        'nomor_pic',
        'sumber_listrik',
        'gateway_area',
        'beam',
        'hub',
        'kodefikasi',
        'sn_antena',
        'sn_modem',
        'sn_router',
        'sn_ap1',
        'sn_ap2',
        'sn_tranciever',
        'sn_stabilizer',
        'sn_rak',
        'ip_modem',
        'ip_router',
        'ip_ap1',
        'ip_ap2',
        'expected_sqf'
    ];

    protected $table = 'sites';

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class,'site_id','site_id');
    }
    public function datapasses()
    {
        return $this->hasMany(DataPass::class, 'site_id');
    }
}
