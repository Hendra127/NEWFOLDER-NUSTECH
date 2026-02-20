<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporan_pm', function (Blueprint $table) {

            // lokasi & wilayah
            $table->string('lokasi_site')->nullable()->after('site_id');
            $table->string('kabupaten_kota')->nullable()->after('lokasi_site');
            $table->string('provinsi')->nullable()->after('kabupaten_kota');

            // pm bulan sudah ada, jadi lanjut setelah pm_bulan
            $table->string('laporan_ba_pm')->nullable()->after('pm_bulan');

            // kendala/masalah
            $table->text('masalah_kendala')->nullable()->after('laporan_ba_pm');

            // action
            $table->text('action')->nullable()->after('masalah_kendala');

            // ket tambahan
            $table->text('ket_tambahan')->nullable()->after('action');

            // status laporan (status baru)
            $table->string('status')->nullable()->after('ket_tambahan');

        });
    }

    public function down(): void
    {
        Schema::table('laporan_pm', function (Blueprint $table) {
            $table->dropColumn([
                'lokasi_site',
                'kabupaten_kota',
                'provinsi',
                'laporan_ba_pm',
                'masalah_kendala',
                'action',
                'ket_tambahan',
                'status_laporan',
            ]);
        });
    }
};