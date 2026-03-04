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
            $table->dropColumn(['metode_pembayaran', 'bukti_pembayaran']);
            $table->string('midtrans_order_id')->nullable()->after('status_pembayaran');
            $table->string('snap_token')->nullable()->after('midtrans_order_id');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaran_pernikahan', function (Blueprint $table) {
            $table->dropColumn(['midtrans_order_id', 'snap_token']);
            $table->string('metode_pembayaran')->nullable()->after('status_pembayaran');
            $table->string('bukti_pembayaran')->nullable()->after('metode_pembayaran');
        });
    }
};
