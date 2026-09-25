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
        Schema::create('quick_count_parties', function (Blueprint $table) {
            $table->id();
            $table->string('party_name');
            $table->integer('party_number')->nullable();
            $table->string('color_hex')->default('#ffb700');
            $table->integer('total_suara')->default(0);
            $table->integer('kursi_dprd')->default(0);
            $table->timestamps();
        });

        Schema::create('quick_count_tps', function (Blueprint $table) {
            $table->id();
            $table->string('dapil')->default('Dapil 1');
            $table->string('kecamatan_name');
            $table->string('desa_name');
            $table->string('tps_number');
            $table->integer('total_dpt')->default(250);
            $table->integer('suara_nasdem')->default(0);
            $table->integer('suara_sah')->default(0);
            $table->integer('suara_tidak_sah')->default(0);
            $table->string('saksi_name')->nullable();
            $table->string('saksi_phone')->nullable();
            $table->string('c1_photo')->nullable();
            $table->string('status')->default('Terverifikasi'); // Terverifikasi, Menunggu Verifikasi, Perlu Koreksi
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quick_count_tps');
        Schema::dropIfExists('quick_count_parties');
    }
};
