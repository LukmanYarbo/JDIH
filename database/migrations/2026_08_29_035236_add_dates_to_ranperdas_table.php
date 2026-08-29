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
        Schema::table('ranperdas', function (Blueprint $table) {
            $table->date('tanggal_mulai_pembahasan')->nullable()->after('tahap_terakhir');
            $table->date('tanggal_akhir_pembahasan')->nullable()->after('tanggal_mulai_pembahasan');
            $table->date('tanggal_penetapan')->nullable()->after('tanggal_akhir_pembahasan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ranperdas', function (Blueprint $table) {
            $table->dropColumn(['tanggal_mulai_pembahasan', 'tanggal_akhir_pembahasan', 'tanggal_penetapan']);
        });
    }
};
