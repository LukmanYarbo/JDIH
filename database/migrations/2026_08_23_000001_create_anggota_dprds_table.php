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
        Schema::create('anggota_dprds', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('jabatan', ['ketua', 'wakil_ketua', 'anggota'])->default('anggota');
            $table->string('fraksi')->nullable();
            $table->string('dapil')->nullable();
            $table->string('foto')->nullable();
            $table->unsignedInteger('no_urut')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota_dprds');
    }
};
