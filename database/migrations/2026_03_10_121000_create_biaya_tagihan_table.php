<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('biaya_tagihan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('biaya_id')->constrained('biaya')->cascadeOnDelete();
            $table->foreignUuid('pendaftaran_id')->constrained('pendaftaran_pernikahan')->cascadeOnDelete();
            $table->string('status', 20)->default('belum_bayar'); // belum_bayar, menunggu, lunas, gagal
            $table->string('midtrans_order_id')->nullable();
            $table->string('midtrans_transaction_id')->nullable();
            $table->string('qris_url')->nullable();
            $table->timestamp('qris_expired_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('biaya_tagihan');
    }
};

