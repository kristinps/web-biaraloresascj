<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftaran_pernikahan', function (Blueprint $table) {
            $table->dropColumn([
                'akta_kelahiran_pria',
                'akta_kelahiran_wanita',
                'surat_belum_menikah_pria',
                'surat_belum_menikah_wanita',
            ]);

            $table->string('surat_pengantar_kombas_pria')->nullable()->after('surat_baptis_wanita');
            $table->string('surat_pengantar_kombas_wanita')->nullable()->after('surat_pengantar_kombas_pria');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaran_pernikahan', function (Blueprint $table) {
            $table->dropColumn(['surat_pengantar_kombas_pria', 'surat_pengantar_kombas_wanita']);

            $table->string('akta_kelahiran_pria')->nullable();
            $table->string('akta_kelahiran_wanita')->nullable();
            $table->string('surat_belum_menikah_pria')->nullable();
            $table->string('surat_belum_menikah_wanita')->nullable();
        });
    }
};
