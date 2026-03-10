<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('biaya', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('jenis', 30)->default('pendaftaran'); // pendaftaran, tambahan
            $table->unsignedBigInteger('nominal')->default(0);
            $table->string('keterangan')->nullable();
            $table->foreignUuid('periode_id')->nullable()->constrained('periode_pernikahan')->nullOnDelete();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('biaya');
    }
};
