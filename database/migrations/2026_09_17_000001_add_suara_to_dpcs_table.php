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
        Schema::table('dpcs', function (Blueprint $table) {
            if (!Schema::hasColumn('dpcs', 'total_suara')) {
                $table->integer('total_suara')->default(0)->after('total_kader');
            }
            if (!Schema::hasColumn('dpcs', 'target_suara')) {
                $table->integer('target_suara')->default(0)->after('total_suara');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dpcs', function (Blueprint $table) {
            $table->dropColumn(['total_suara', 'target_suara']);
        });
    }
};
