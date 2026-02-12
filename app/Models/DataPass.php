<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPass extends Model
{
    use HasFactory;

    protected $table = 'datapass';

    protected $fillable = [
        'site_id',
        'nama_lokasi',
        'kabupaten',
        'adop',
        'pass_ap1',
        'pass_ap2',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }
}
