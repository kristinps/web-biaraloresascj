<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materi_kursus', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('periode_id')->constrained('periode_pernikahan')->cascadeOnDelete();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('file_materi')->nullable();
            $table->string('zoom_link', 500)->nullable();
            $table->date('tanggal_pelaksanaan')->nullable();
            $table->unsignedTinyInteger('urutan')->default(1);
            $table->boolean('terkirim_materi')->default(false);
            $table->boolean('terkirim_zoom')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materi_kursus');
    }
};
