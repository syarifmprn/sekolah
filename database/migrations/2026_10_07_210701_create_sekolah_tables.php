<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Berita
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->date('tanggal');
            $table->longText('isi');
            $table->string('thumbnail')->nullable();
            $table->timestamps();
        });

        // 2. Prestasi
        Schema::create('prestasis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kegiatan');
            $table->string('hasil');
            $table->year('tahun');
            $table->enum('tipe', ['sekolah', 'nasional', 'daerah', 'internasional']);
            $table->json('dokumentasi')->nullable(); // For up to 3 images
            $table->timestamps();
        });

        // 3. Pengumuman
        Schema::create('pengumumans', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->date('tanggal');
            $table->text('isi');
            $table->string('dokumen')->nullable();
            $table->string('thumbnail')->nullable();
            $table->timestamps();
        });

        // 4. Guru
        Schema::create('gurus', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jabatan'); // Mata Pelajaran/Jabatan
            $table->string('foto')->nullable();
            $table->timestamps();
        });

        // 5. Galeri
        Schema::create('galeris', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->nullable();
            $table->string('foto'); // path to photo
            $table->timestamps();
        });

        // 6. Halaman
        Schema::create('halamans', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->date('tanggal');
            $table->longText('isi');
            $table->string('thumbnail')->nullable();
            $table->timestamps();
        });

        // 7. Menu
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('nama_menu');
            $table->string('link');
            $table->timestamps();
        });

        // 8. Sub Menu
        Schema::create('sub_menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('menus')->cascadeOnDelete();
            $table->string('nama_menu');
            $table->string('link');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_menus');
        Schema::dropIfExists('menus');
        Schema::dropIfExists('halamans');
        Schema::dropIfExists('galeris');
        Schema::dropIfExists('gurus');
        Schema::dropIfExists('pengumumans');
        Schema::dropIfExists('prestasis');
        Schema::dropIfExists('beritas');
    }
};
