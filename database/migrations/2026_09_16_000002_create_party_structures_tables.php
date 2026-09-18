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
        Schema::create('dpd_officers', function (Blueprint $table) {
            $table->id();
            $table->string('category')->default('inti'); // inti / bidang
            $table->string('title'); // Ketua, Wakil Ketua, Sekretaris, dll.
            $table->string('name')->nullable();
            $table->string('photo')->nullable();
            $table->string('phone')->nullable();
            $table->string('sk_number')->nullable();
            $table->integer('sort_order')->default(0);
            $table->string('status')->default('Aktif');
            $table->timestamps();
        });

        Schema::create('dpcs', function (Blueprint $table) {
            $table->id();
            $table->string('kecamatan_name')->unique();
            $table->string('dapil')->default('Dapil 1');
            $table->string('office_address')->nullable();
            $table->string('ketua_name')->nullable();
            $table->string('sekretaris_name')->nullable();
            $table->string('bendahara_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('sk_number')->nullable();
            $table->string('status')->default('SK Definitif');
            $table->integer('total_ranting')->default(0);
            $table->integer('total_kader')->default(0);
            $table->timestamps();
        });

        Schema::create('dprts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dpc_id')->nullable()->constrained('dpcs')->nullOnDelete();
            $table->string('kecamatan_name');
            $table->string('desa_name');
            $table->string('type')->default('Desa'); // Desa / Kelurahan
            $table->string('ketua_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('status')->default('Terbentuk SK'); // Terbentuk SK / Mandataris / Belum Terbentuk
            $table->integer('total_kader')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dprts');
        Schema::dropIfExists('dpcs');
        Schema::dropIfExists('dpd_officers');
    }
};
