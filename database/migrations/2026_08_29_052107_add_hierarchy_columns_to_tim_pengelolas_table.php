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
        Schema::table('tim_pengelolas', function (Blueprint $table) {
            $table->string('kategori_jabatan')->default('bidang')->after('nip'); 
            // values: pembina, penanggung_jawab, ketua, wakil_ketua, sekretaris, bidang
            $table->string('peran_bidang')->nullable()->after('divisi');
            // values for bidang: Ketua Bidang, Anggota Bidang
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tim_pengelolas', function (Blueprint $table) {
            $table->dropColumn(['kategori_jabatan', 'peran_bidang']);
        });
    }
};
