<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftaran_pernikahan', function (Blueprint $table) {
            $table->string('status_dokumen', 30)->default('belum_diperiksa')->after('catatan');
            $table->text('catatan_dokumen')->nullable()->after('status_dokumen');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaran_pernikahan', function (Blueprint $table) {
            $table->dropColumn(['status_dokumen', 'catatan_dokumen']);
        });
    }
};
