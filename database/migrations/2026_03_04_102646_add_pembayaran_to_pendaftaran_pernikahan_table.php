<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftaran_pernikahan', function (Blueprint $table) {
            $table->string('metode_pembayaran')->nullable()->after('catatan');
            $table->string('bukti_pembayaran')->nullable()->after('metode_pembayaran');
            $table->string('status_pembayaran')->default('belum_bayar')->after('bukti_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaran_pernikahan', function (Blueprint $table) {
            $table->dropColumn(['metode_pembayaran', 'bukti_pembayaran', 'status_pembayaran']);
        });
    }
};
