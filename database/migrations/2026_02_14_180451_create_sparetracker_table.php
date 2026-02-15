<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sparetracker', function (Blueprint $table) {

            // Masuk
            $table->string('sn')->nullable()->after('id');
            $table->string('nama_perangkat')->nullable()->after('sn');

            $table->string('jenis')->nullable()->after('nama_perangkat');
            $table->string('type')->nullable()->after('jenis');

            $table->string('kondisi')->nullable()->after('type');
            $table->string('pengadaan_by')->nullable()->after('kondisi');

            $table->string('lokasi_asal')->nullable()->after('pengadaan_by');
            $table->string('lokasi')->nullable()->after('lokasi_asal');

            $table->string('bulan_masuk')->nullable()->after('lokasi');
            $table->date('tanggal_masuk')->nullable()->after('bulan_masuk');

            // Status & realtime
            $table->string('status_penggunaan_sparepart')->nullable()->after('tanggal_masuk');
            $table->string('lokasi_realtime')->nullable()->after('status_penggunaan_sparepart');
            $table->string('kabupaten')->nullable()->after('lokasi_realtime');

            // Keluar
            $table->string('bulan_keluar')->nullable()->after('kabupaten');
            $table->date('tanggal_keluar')->nullable()->after('bulan_keluar');

            // Lainnya
            $table->string('layanan_ai')->nullable()->after('tanggal_keluar');
            $table->text('keterangan')->nullable()->after('layanan_ai');
        });
    }

    public function down(): void
    {
        Schema::table('sparetracker', function (Blueprint $table) {
            $table->dropColumn([
                'sn',
                'nama_perangkat',
                'jenis',
                'type',
                'kondisi',
                'pengadaan_by',
                'lokasi_asal',
                'lokasi',
                'bulan_masuk',
                'tanggal_masuk',
                'status_penggunaan_sparepart',
                'lokasi_realtime',
                'kabupaten',
                'bulan_keluar',
                'tanggal_keluar',
                'layanan_ai',
                'keterangan',
            ]);
        });
    }
};