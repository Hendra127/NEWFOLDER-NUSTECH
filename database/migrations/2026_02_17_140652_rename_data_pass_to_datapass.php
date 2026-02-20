<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk mengubah nama tabel.
     */
    public function up(): void
    {
        // Perintah untuk mengubah nama dari lama ke baru
        Schema::rename('data_pass_', 'datapass');
    }

    /**
     * Batalkan migrasi (rollback).
     */
    public function down(): void
    {
        // Perintah untuk mengembalikan nama jika migrasi di-rollback
        Schema::rename('datapass', 'data_pass_');
    }
};