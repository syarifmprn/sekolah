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
        Schema::create('ekstrakurikulers', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('kategori', 50); // Olahraga / Seni / Akademik / Keagamaan / Lainnya
            $table->text('deskripsi')->nullable();
            $table->string('logo', 255)->nullable();
            $table->json('galeri')->nullable(); // Banyak foto (upload multiple)
            $table->string('pembina', 100)->nullable();
            $table->string('ketua', 100)->nullable();
            $table->string('hari', 20)->nullable(); // Hari latihan
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->string('tempat', 100)->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ekstrakurikulers');
    }
};
