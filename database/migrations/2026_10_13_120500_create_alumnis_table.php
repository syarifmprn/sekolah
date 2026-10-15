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
        Schema::create('alumnis', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->year('tahun_lulus'); // Angkatan / tahun lulus
            $table->string('jurusan', 50)->nullable(); // IPA / IPS / dll (opsional)
            $table->string('foto', 255)->nullable(); // Path foto alumni
            $table->string('pekerjaan', 100)->nullable(); // Pekerjaan / profesi saat ini
            $table->string('instansi', 150)->nullable(); // Tempat kerja / kampus
            $table->string('alamat', 150)->nullable(); // Kota domisili (opsional)
            $table->string('no_hp', 20)->nullable(); // Kontak (opsional)
            $table->string('email', 100)->nullable(); // (opsional)
            $table->text('testimoni')->nullable(); // Kesan, pesan, dan cerita sukses
            $table->enum('tampil', ['ya', 'tidak'])->default('tidak'); // Tampilkan testimoni di website
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnis');
    }
};
