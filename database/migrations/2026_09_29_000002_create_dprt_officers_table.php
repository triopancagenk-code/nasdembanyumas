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
        Schema::create('dprt_officers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dprt_id')->constrained('dprts')->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->string('title'); // Jabatan: Ketua DPRt, Sekretaris, Bendahara, dll.
            $table->string('category')->default('inti'); // inti / bidang
            $table->string('sk_number')->nullable();
            $table->string('phone')->nullable();
            $table->string('instagram')->nullable(); // Username atau tautan Instagram
            $table->string('photo')->nullable();
            $table->integer('sort_order')->default(1);
            $table->string('status')->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dprt_officers');
    }
};
