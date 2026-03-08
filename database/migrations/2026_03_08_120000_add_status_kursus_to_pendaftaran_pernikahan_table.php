<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftaran_pernikahan', function (Blueprint $table) {
            if (!Schema::hasColumn('pendaftaran_pernikahan', 'status_kursus')) {
                $table->string('status_kursus', 30)->default('terjadwal')->after('catatan_dokumen');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaran_pernikahan', function (Blueprint $table) {
            $table->dropColumn('status_kursus');
        });
    }
};
