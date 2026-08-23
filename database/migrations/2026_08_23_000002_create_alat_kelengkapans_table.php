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
        Schema::create('alat_kelengkapans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('tipe', ['komisi', 'banggar', 'banmus', 'bapemperda', 'bk']);
            $table->text('keterangan')->nullable();
            $table->unsignedInteger('no_urut')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        Schema::create('keanggotaan_alat_kelengkapans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alat_kelengkapan_id')->constrained('alat_kelengkapans')->cascadeOnDelete();
            $table->foreignId('anggota_dprd_id')->constrained('anggota_dprds')->cascadeOnDelete();
            $table->enum('jabatan', ['ketua', 'wakil', 'sekretaris', 'anggota'])->default('anggota');
            $table->unsignedInteger('no_urut')->default(0);
            $table->timestamps();

            $table->unique(['alat_kelengkapan_id', 'anggota_dprd_id'], 'keanggotaan_ak_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keanggotaan_alat_kelengkapans');
        Schema::dropIfExists('alat_kelengkapans');
    }
};
