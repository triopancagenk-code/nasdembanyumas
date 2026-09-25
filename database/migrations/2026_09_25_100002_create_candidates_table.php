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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('tingkat')->default('DPRD Kabupaten'); // DPRD Kabupaten, DPRD Provinsi, DPR RI
            $table->string('dapil')->default('Dapil 1'); // Dapil 1 - 6
            $table->integer('nomor_urut')->default(1);
            $table->string('jenis_kelamin')->default('L'); // L / P
            $table->string('foto')->nullable();
            $table->string('jabatan')->nullable(); // Misal: Wakil Ketua DPD, Ketua DPC, Tokoh Pendidik
            $table->string('basis_wilayah')->nullable(); // Kecamatan basis pemenangan
            $table->integer('target_suara')->default(5000);
            $table->integer('suara_masuk')->default(0);
            $table->string('status')->default('DCT'); // DCT, Terpilih, Aktif
            $table->string('slogan')->nullable();
            $table->string('phone')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
