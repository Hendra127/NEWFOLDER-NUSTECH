<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pmliberta', function (Blueprint $table) {
            $table->id();
            $table->string('site_id')->nullable(); // Ubah ke string agar bisa menampung kode site
            $table->string('nama_lokasi')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('pic_ce')->nullable();
            $table->string('month')->nullable();
            $table->string('date')->nullable();
            $table->string('status')->nullable();
            $table->string('week')->nullable();
            $table->string('kategori')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pmliberta');
    }
};
