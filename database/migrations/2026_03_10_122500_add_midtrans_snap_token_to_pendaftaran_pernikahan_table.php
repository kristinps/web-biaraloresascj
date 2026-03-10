<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('pendaftaran_pernikahan', 'midtrans_snap_token')) {
            Schema::table('pendaftaran_pernikahan', function (Blueprint $table) {
                $table->string('midtrans_snap_token')->nullable()->after('midtrans_order_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('pendaftaran_pernikahan', 'midtrans_snap_token')) {
            Schema::table('pendaftaran_pernikahan', function (Blueprint $table) {
                $table->dropColumn('midtrans_snap_token');
            });
        }
    }
};

