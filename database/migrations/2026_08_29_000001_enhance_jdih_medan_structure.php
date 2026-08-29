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
        // 1. Enhance jenis_dokumens
        Schema::table('jenis_dokumens', function (Blueprint $table) {
            if (!Schema::hasColumn('jenis_dokumens', 'tipe_dokumen')) {
                $table->string('tipe_dokumen')->default('Produk Hukum')->after('id'); // 'Produk Hukum', 'Monografi Hukum', 'Artikel Hukum', 'Putusan Pengadilan'
            }
            if (!Schema::hasColumn('jenis_dokumens', 'urutan')) {
                $table->integer('urutan')->default(0)->after('deskripsi');
            }
            if (!Schema::hasColumn('jenis_dokumens', 'icon')) {
                $table->string('icon')->nullable()->after('urutan');
            }
        });

        // 2. Enhance dokumen_hukums
        Schema::table('dokumen_hukums', function (Blueprint $table) {
            if (!Schema::hasColumn('dokumen_hukums', 'tipe_dokumen')) {
                $table->string('tipe_dokumen')->default('Produk Hukum')->after('jenis_dokumen_id');
            }
            if (!Schema::hasColumn('dokumen_hukums', 'tanggal_pengundangan')) {
                $table->date('tanggal_pengundangan')->nullable()->after('tanggal_ditetapkan');
            }
            if (!Schema::hasColumn('dokumen_hukums', 'penandatangan')) {
                $table->string('penandatangan')->nullable()->after('tanggal_pengundangan');
            }
            if (!Schema::hasColumn('dokumen_hukums', 'pemrakarsa')) {
                $table->string('pemrakarsa')->nullable()->after('penandatangan'); // Inisiatif DPRD / Pemerintah Daerah
            }
            if (!Schema::hasColumn('dokumen_hukums', 'tempat_terbit')) {
                $table->string('tempat_terbit')->default('Medan')->after('pemrakarsa');
            }
            if (!Schema::hasColumn('dokumen_hukums', 'sumber')) {
                $table->string('sumber')->nullable()->after('tempat_terbit'); // Lembaran Daerah / Berita Daerah dll
            }
            if (!Schema::hasColumn('dokumen_hukums', 'subjek')) {
                $table->string('subjek')->nullable()->after('sumber');
            }
            if (!Schema::hasColumn('dokumen_hukums', 'bidang_hukum')) {
                $table->string('bidang_hukum')->nullable()->after('subjek');
            }
            if (!Schema::hasColumn('dokumen_hukums', 'bahasa')) {
                $table->string('bahasa')->default('Indonesia')->after('bidang_hukum');
            }
            if (!Schema::hasColumn('dokumen_hukums', 'lokasi_arsip')) {
                $table->string('lokasi_arsip')->nullable()->after('bahasa');
            }
            if (!Schema::hasColumn('dokumen_hukums', 'keterangan_status')) {
                $table->text('keterangan_status')->nullable()->after('status');
            }
            if (!Schema::hasColumn('dokumen_hukums', 'file_abstrak')) {
                $table->string('file_abstrak')->nullable()->after('abstrak');
            }
            if (!Schema::hasColumn('dokumen_hukums', 'file_lampiran')) {
                $table->string('file_lampiran')->nullable()->after('file_abstrak');
            }
            if (!Schema::hasColumn('dokumen_hukums', 'file_size')) {
                $table->string('file_size')->nullable()->after('file_lampiran');
            }
            if (!Schema::hasColumn('dokumen_hukums', 'downloads')) {
                $table->integer('downloads')->default(0)->after('hits');
            }
        });

        // 3. Enhance profils
        Schema::table('profils', function (Blueprint $table) {
            if (!Schema::hasColumn('profils', 'dasar_hukum')) {
                $table->text('dasar_hukum')->nullable()->after('misi');
            }
            if (!Schema::hasColumn('profils', 'sk_tim')) {
                $table->text('sk_tim')->nullable()->after('dasar_hukum');
            }
            if (!Schema::hasColumn('profils', 'sop')) {
                $table->text('sop')->nullable()->after('sk_tim');
            }
            if (!Schema::hasColumn('profils', 'maklumat_pelayanan')) {
                $table->text('maklumat_pelayanan')->nullable()->after('sop');
            }
            if (!Schema::hasColumn('profils', 'jam_operasional')) {
                $table->string('jam_operasional')->nullable()->after('maklumat_pelayanan');
            }
            if (!Schema::hasColumn('profils', 'file_sk_tim')) {
                $table->string('file_sk_tim')->nullable()->after('jam_operasional');
            }
            if (!Schema::hasColumn('profils', 'file_sop')) {
                $table->string('file_sop')->nullable()->after('file_sk_tim');
            }
            if (!Schema::hasColumn('profils', 'video_profil')) {
                $table->string('video_profil')->nullable()->after('file_sop');
            }
            if (!Schema::hasColumn('profils', 'facebook')) {
                $table->string('facebook')->nullable()->after('video_profil');
            }
            if (!Schema::hasColumn('profils', 'instagram')) {
                $table->string('instagram')->nullable()->after('facebook');
            }
            if (!Schema::hasColumn('profils', 'youtube')) {
                $table->string('youtube')->nullable()->after('instagram');
            }
            if (!Schema::hasColumn('profils', 'twitter')) {
                $table->string('twitter')->nullable()->after('youtube');
            }
            if (!Schema::hasColumn('profils', 'whatsapp')) {
                $table->string('whatsapp')->nullable()->after('twitter');
            }
        });

        // 4. Create agendas table (for running ticker & agenda DPRD)
        if (!Schema::hasTable('agendas')) {
            Schema::create('agendas', function (Blueprint $table) {
                $table->id();
                $table->string('judul');
                $table->dateTime('waktu_mulai');
                $table->dateTime('waktu_selesai')->nullable();
                $table->string('lokasi')->nullable();
                $table->text('deskripsi')->nullable();
                $table->string('pelaksana')->nullable(); // e.g. Bapemperda, Pansus, Banggar, Paripurna, Komisi
                $table->string('status')->default('Akan Datang'); // Akan Datang, Berlangsung, Selesai
                $table->boolean('is_active_ticker')->default(true);
                $table->timestamps();
            });
        }

        // 5. Create ranperdas table (for Propemperda & tracking flow)
        if (!Schema::hasTable('ranperdas')) {
            Schema::create('ranperdas', function (Blueprint $table) {
                $table->id();
                $table->integer('tahun');
                $table->string('nomor_propemperda')->nullable();
                $table->text('judul');
                $table->string('pemrakarsa')->default('DPRD'); // DPRD / Kepala Daerah / Pemkot
                $table->tinyInteger('tahap_terakhir')->default(1); // 1: Pengusulan, 2: Naskah Akademik, 3: Harmonisasi, 4: Pembahasan Pansus, 5: Paripurna, 6: Fasilitasi Kemendagri, 7: Penetapan & Pengundangan
                $table->string('status')->default('Dalam Pembahasan'); // Dalam Pembahasan, Disetujui, Ditetapkan, Ditolak
                $table->text('keterangan')->nullable();
                $table->string('file_naskah_akademik')->nullable();
                $table->string('file_rancangan')->nullable();
                $table->string('file_evaluasi')->nullable();
                $table->integer('hits')->default(0);
                $table->timestamps();
            });
        }

        // 6. Create buletins table
        if (!Schema::hasTable('buletins')) {
            Schema::create('buletins', function (Blueprint $table) {
                $table->id();
                $table->string('edisi'); // e.g. "EDISI JAN-MAR 2026", "RANGKUMAN 2025"
                $table->integer('tahun');
                $table->string('judul');
                $table->string('cover_image')->nullable();
                $table->string('file_pdf')->nullable();
                $table->text('deskripsi')->nullable();
                $table->integer('downloads')->default(0);
                $table->timestamps();
            });
        }

        // 7. Create ikm_votes table (Indeks Kepuasan Masyarakat)
        if (!Schema::hasTable('ikm_votes')) {
            Schema::create('ikm_votes', function (Blueprint $table) {
                $table->id();
                $table->string('jawaban'); // Sangat Informatif, Informatif, Biasa Saja, Kurang Informatif
                $table->string('ip_address')->nullable();
                $table->string('user_agent')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ikm_votes');
        Schema::dropIfExists('buletins');
        Schema::dropIfExists('ranperdas');
        Schema::dropIfExists('agendas');
        
        Schema::table('profils', function (Blueprint $table) {
            $table->dropColumn([
                'dasar_hukum', 'sk_tim', 'sop', 'maklumat_pelayanan', 'jam_operasional',
                'file_sk_tim', 'file_sop', 'video_profil', 'facebook', 'instagram', 'youtube', 'twitter', 'whatsapp'
            ]);
        });

        Schema::table('dokumen_hukums', function (Blueprint $table) {
            $table->dropColumn([
                'tipe_dokumen', 'tanggal_pengundangan', 'penandatangan', 'pemrakarsa',
                'tempat_terbit', 'sumber', 'subjek', 'bidang_hukum', 'bahasa', 'lokasi_arsip',
                'keterangan_status', 'file_abstrak', 'file_lampiran', 'file_size', 'downloads'
            ]);
        });

        Schema::table('jenis_dokumens', function (Blueprint $table) {
            $table->dropColumn(['tipe_dokumen', 'urutan', 'icon']);
        });
    }
};
