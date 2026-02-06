<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
        $table->engine = 'InnoDB';

        $table->id();

        // FK ke project_phases (PASTIKAN tabel ini dibuat LEBIH DULU)
        $table->unsignedBigInteger('phase_id');

        // FK ke users (optional)
        $table->unsignedBigInteger('user_id')->nullable();

        $table->string('nama');
        $table->string('status');
        $table->timestamps();

        $table->foreign('phase_id')
            ->references('id')
            ->on('project_phases')
            ->onDelete('cascade');

        $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->nullOnDelete();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
