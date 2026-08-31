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
        Schema::table('profils', function (Blueprint $table) {
            $table->string('nama_kantor')->nullable()->after('id');
            $table->string('nama_singkat_kantor')->nullable()->after('nama_kantor');
            $table->string('nama_wilayah')->nullable()->after('nama_singkat_kantor');
            $table->string('nama_sekretariat')->nullable()->after('nama_wilayah');
            $table->string('welcome_title')->nullable()->after('nama_sekretariat');
            $table->string('welcome_subtitle')->nullable()->after('welcome_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profils', function (Blueprint $table) {
            $table->dropColumn([
                'nama_kantor',
                'nama_singkat_kantor',
                'nama_wilayah',
                'nama_sekretariat',
                'welcome_title',
                'welcome_subtitle',
            ]);
        });
    }
};
