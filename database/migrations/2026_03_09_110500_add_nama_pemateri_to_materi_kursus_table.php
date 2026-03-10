<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('materi_kursus', function (Blueprint $table) {
            $table->string('nama_pemateri')->nullable()->after('judul');
        });
    }

    public function down(): void
    {
        Schema::table('materi_kursus', function (Blueprint $table) {
            $table->dropColumn('nama_pemateri');
        });
    }
};

