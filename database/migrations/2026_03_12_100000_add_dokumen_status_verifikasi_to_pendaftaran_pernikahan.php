<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftaran_pernikahan', function (Blueprint $table) {
            if (!Schema::hasColumn('pendaftaran_pernikahan', 'dokumen_status_verifikasi')) {
                $table->json('dokumen_status_verifikasi')->nullable()->after('perbaikan_dokumen_user');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaran_pernikahan', function (Blueprint $table) {
            $table->dropColumn('dokumen_status_verifikasi');
        });
    }
};
