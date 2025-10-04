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
        Schema::create('perkara', function (Blueprint $table) {
            $table->id();
            // Data Identitas Perkara
            $table->string('satker'); // Nama Pengadilan Agama
            $table->string('no_reg_pa'); // Nomor register PA
            $table->string('jenis_perkara'); // Jenis perkara
            $table->string('keterangan')->nullable(); // e-court atau non e-court
            $table->string('pembanding')->nullable(); // Nama Pembanding
            $table->string('terbanding')->nullable(); // Nama Terbanding

            // Kronologi di PA
            $table->date('tgl_put_pa')->nullable(); // Tanggal putusan Pengadilan Agama
            $table->date('tgl_akta_banding')->nullable(); // Tanggal akta banding
            $table->string('no_srt_pa')->nullable(); // Nomor surat PA ke PTA
            $table->date('tgl_srt_pa')->nullable(); // Tanggal surat dari PA ke PTA

            // Penerimaan & Registrasi di PTA
            $table->date('tgl_trm_pta')->nullable(); // Tanggal terima PTA
            $table->string('no_reg_pta')->unique(); // Nomor register PTA (UNIK)
            $table->date('tgl_reg_pta')->nullable(); // Tanggal register PTA

            // Pembentukan Majelis
            $table->date('tgl_pmh')->nullable(); // Tanggal penunjukkan majelis hakim
            $table->string('hakim_ketua')->nullable(); // Hakim Ketua
            $table->string('hakim_anggota1')->nullable(); // Hakim Anggota 1
            $table->string('hakim_anggota2')->nullable(); // Hakim Anggota 2
            $table->date('tgl_ppp')->nullable(); // Tanggal penunjukkan panitera pengganti
            $table->string('panitera_pengganti')->nullable(); // Panitera Pengganti
            $table->date('tgl_trm_km')->nullable(); // Tanggal berkas diterima oleh ketua majelis

            // Proses Persidangan
            $table->date('tgl_phs')->nullable(); // Tanggal penetapan hari sidang
            $table->date('tgl_sidang')->nullable(); // Tanggal sidang
            $table->date('tgl_sela')->nullable(); // Tanggal sela
            $table->date('tgl_putus')->nullable(); // Tanggal putusan
            $table->string('status_put')->nullable(); // Status Putusan PTA

            // Administrasi Pasca Putusan
            $table->date('tgl_minut')->nullable(); // Tanggal Minutasi
            $table->date('tgl_serah')->nullable(); // Tanggal serah ke Meja3
            $table->date('tgl_srt_pta')->nullable(); // Tanggal surat PTA ke PA
            $table->date('tgl_kirim_pta')->nullable(); // Tanggal kirim PTA ke PA

            // Data Tambahan (Alamat & Tembusan)
            $table->string('alamat_pa')->nullable(); // Alamat PA
            $table->string('tembusan')->nullable();
            $table->string('tembusan1')->nullable();
            $table->string('tembusan2')->nullable();
            $table->string('tembusan3')->nullable();
            $table->string('almt_tembusan')->nullable();
            $table->string('almt_tembusan1')->nullable();
            $table->string('almt_tembusan2')->nullable();
            $table->string('almt_tembusan3')->nullable();

            $table->timestamps(); // created_at dan updated_at
            $table->softDeletes(); // Tambahkan ini untuk menerapkan SoftDeletes

            // Tambahkan index untuk field yang sering di-query
            $table->index('no_reg_pta');
            $table->index('tgl_sidang');
            $table->index('tgl_putus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perkara');
    }
};
