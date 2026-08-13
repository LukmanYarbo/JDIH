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
        Schema::create('dokumen_hukums', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_dokumen_id')->constrained('jenis_dokumens')->onDelete('cascade');
            $table->text('judul');
            $table->string('nomor');
            $table->integer('tahun');
            $table->date('tanggal_ditetapkan')->nullable();
            $table->string('file_pdf')->nullable();
            $table->text('abstrak')->nullable();
            $table->string('status')->default('Berlaku'); // Berlaku, Tidak Berlaku, Diubah, Mencabut
            $table->integer('hits')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_hukums');
    }
};
