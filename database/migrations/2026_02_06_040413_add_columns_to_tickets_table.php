<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {

            $table->string('nama_site')->nullable()->after('site_id');
            $table->string('provinsi')->nullable()->after('nama_site');
            $table->string('kabupaten')->nullable()->after('provinsi');

            $table->date('tanggal_rekap')->nullable()->after('kategori');
            $table->string('bulan_open')->nullable()->after('tanggal_rekap');

            $table->string('status_tiket')->nullable()->after('status');

            $table->date('tanggal_close')->nullable()->after('kendala');
            $table->string('bulan_close')->nullable()->after('tanggal_close');

            $table->string('evidence')->nullable()->after('bulan_close');

            $table->text('plan_actions')->nullable()->after('detail_problem');
            $table->string('ce')->nullable()->after('plan_actions');

            $table->integer('durasi_akhir')->nullable()->after('durasi');
        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn([
                'nama_site',
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
            ]);
        });
    }
};
