<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kehadiran_kursus', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('pendaftaran_id')->constrained('pendaftaran_pernikahan')->cascadeOnDelete();
            $table->foreignUuid('materi_kursus_id')->constrained('materi_kursus')->cascadeOnDelete();
            $table->boolean('hadir_tatap_muka')->default(false);
            $table->boolean('hadir_zoom')->default(false);
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(['pendaftaran_id', 'materi_kursus_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kehadiran_kursus');
    }
};
