<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftaran_pernikahan', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Data Calon Mempelai Pria
            $table->string('nama_pria');
            $table->string('tempat_lahir_pria');
            $table->date('tanggal_lahir_pria');
            $table->string('nik_pria', 20);
            $table->string('agama_pria')->default('Katolik');
            $table->string('pekerjaan_pria');
            $table->text('alamat_pria');
            $table->string('nama_ayah_pria');
            $table->string('nama_ibu_pria');

            // Data Calon Mempelai Wanita
            $table->string('nama_wanita');
            $table->string('tempat_lahir_wanita');
            $table->date('tanggal_lahir_wanita');
            $table->string('nik_wanita', 20);
            $table->string('agama_wanita')->default('Katolik');
            $table->string('pekerjaan_wanita');
            $table->text('alamat_wanita');
            $table->string('nama_ayah_wanita');
            $table->string('nama_ibu_wanita');

            // Rencana Pernikahan
            $table->date('tanggal_pernikahan');
            $table->string('tempat_pernikahan');

            // Kontak
            $table->string('email');
            $table->string('nomor_hp', 20);

            // Dokumen Upload
            $table->string('ktp_pria')->nullable();
            $table->string('ktp_wanita')->nullable();
            $table->string('akta_kelahiran_pria')->nullable();
            $table->string('akta_kelahiran_wanita')->nullable();
            $table->string('surat_baptis_pria')->nullable();
            $table->string('surat_baptis_wanita')->nullable();
            $table->string('surat_belum_menikah_pria')->nullable();
            $table->string('surat_belum_menikah_wanita')->nullable();

            // Status
            $table->enum('status', ['pending', 'proses', 'selesai'])->default('pending');
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_pernikahan');
    }
};
