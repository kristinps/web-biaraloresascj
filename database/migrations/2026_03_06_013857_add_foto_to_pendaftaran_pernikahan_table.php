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
        Schema::table('pendaftaran_pernikahan', function (Blueprint $table) {
            $table->string('foto_pria')->nullable()->after('ktp_wanita');
            $table->string('foto_wanita')->nullable()->after('foto_pria');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaran_pernikahan', function (Blueprint $table) {
            $table->dropColumn(['foto_pria', 'foto_wanita']);
        });
    }
};
