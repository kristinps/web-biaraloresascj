<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('pendaftaran_pernikahan', 'periode_id')) {
            Schema::table('pendaftaran_pernikahan', function (Blueprint $table) {
                $table->foreignUuid('periode_id')->nullable()->after('id')
                      ->constrained('periode_pernikahan')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasColumn('pendaftaran_pernikahan', 'periode_id')) {
            return;
        }

        $foreignKeyExists = DB::selectOne("
            SELECT 1 FROM information_schema.TABLE_CONSTRAINTS
            WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'pendaftaran_pernikahan'
            AND CONSTRAINT_NAME = 'pendaftaran_pernikahan_periode_id_foreign'
        ", [DB::getDatabaseName()]);

        Schema::table('pendaftaran_pernikahan', function (Blueprint $table) use ($foreignKeyExists) {
            if ($foreignKeyExists) {
                $table->dropForeign(['periode_id']);
            }
            $table->dropColumn('periode_id');
        });
    }
};
