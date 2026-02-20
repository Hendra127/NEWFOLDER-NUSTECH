<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // GANTI 'table' MENJADI 'create'
        Schema::create('sparetracker', function (Blueprint $table) {
            $table->id(); // Tambahkan ID sebagai primary key

            // Masuk
            $table->string('sn')->nullable();
            $table->string('nama_perangkat')->nullable();
            $table->string('jenis')->nullable();
            $table->string('type')->nullable();
            $table->string('kondisi')->nullable();
            $table->string('pengadaan_by')->nullable();
            $table->string('lokasi_asal')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('bulan_masuk')->nullable();
            $table->date('tanggal_masuk')->nullable();

            // Status & realtime
            $table->string('status_penggunaan_sparepart')->nullable();
            $table->string('lokasi_realtime')->nullable();
            $table->string('kabupaten')->nullable();

            // Keluar
            $table->string('bulan_keluar')->nullable();
            $table->date('tanggal_keluar')->nullable();

            // Lainnya
            $table->string('layanan_ai')->nullable();
            $table->text('keterangan')->nullable();
            
            $table->timestamps(); // Standar Laravel untuk created_at & updated_at
        });
    }

    public function down(): void
    {
        // GANTI MENJADI DROP
        Schema::dropIfExists('sparetracker');
    }
};