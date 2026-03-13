<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menyimpan kata sandi sementara untuk dikirim via email setelah pembayaran lunas.
     */
    public function up(): void
    {
        Schema::table('pendaftaran_pernikahan', function (Blueprint $table) {
            $table->string('plain_password_for_email', 255)->nullable()->after('email_konfirmasi_pembayaran_sent_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran_pernikahan', function (Blueprint $table) {
            $table->dropColumn('plain_password_for_email');
        });
    }
};
