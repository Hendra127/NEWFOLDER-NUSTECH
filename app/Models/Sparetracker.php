<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sparetracker extends Model
{
      protected $table = 'sparetracker';

    protected $fillable = [
        'sn', 'nama_perangkat', 'jenis', 'type', 'kondisi', 'pengadaan_by',
        'lokasi_asal', 'lokasi', 'bulan_masuk', 'tanggal_masuk',
        'status_penggunaan_sparepart', 'lokasi_realtime', 'kabupaten',
        'bulan_keluar', 'tanggal_keluar', 'layanan_ai', 'keterangan'
    ];

    protected static function boot()
{
    parent::boot();

    static::updating(function ($model) {
        if ($model->isDirty('sn') && $model->lokasi_realtime) {
            $column = null;
            $jenis = strtoupper(trim($model->jenis));

            // Tentukan kolom berdasarkan jenis perangkat
            switch ($jenis) {
                case 'MODEM':
                    $column = 'sn_modem';
                    break;
                case 'ROUTER':
                    $column = 'sn_router';
                    break;
                case 'SWITCH':
                    $column = 'sn_switch';
                    break;
                case 'AP1':
                case 'ACCESS POINT 1':
                case 'AP 1':
                    $column = 'sn_ap1';
                    break;
                case 'AP2':
                case 'ACCESS POINT 2':
                case 'AP 2':
                    $column = 'sn_ap2';
                    break;
                case 'AP2':
                case 'STAVOL':
                case 'STABILIZER':
                    $datasite->sn_stabilizer = $data->sn;
                    break;
            }

            if ($column) {
                // Update sn_xxx berdasarkan lokasi realtime = sitename
                DB::table('datasite')
                    ->where('sitename', $model->lokasi_realtime)
                    ->update([$column => $model->sn]);
            }
        }
    });
}

}