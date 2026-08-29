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
        Schema::create('tim_pengelolas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nip')->nullable();
            $table->string('jabatan_tim'); // e.g. Pengarah, Penanggung Jawab, Ketua Tim, Sekretaris, Tim IT/Teknis, Anggota
            $table->string('jabatan_struktural')->nullable(); // e.g. Sekretaris DPRD, Kabag Hukum, Kasubag, Pranata Komputer
            $table->string('divisi')->nullable(); // e.g. Pimpinan Tim, Tim Pengolah Data, Tim TI & Jaringan, Tim Layanan
            $table->string('foto')->nullable();
            $table->string('kontak')->nullable();
            $table->text('tugas')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tim_pengelolas');
    }
};
