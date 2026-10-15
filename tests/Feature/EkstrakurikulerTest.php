<?php

namespace Tests\Feature;

use App\Models\Ekstrakurikuler;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EkstrakurikulerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_with_permission_can_access_ekstrakurikuler_management(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'permissions' => ['ekstrakurikuler'],
        ]);

        $response = $this->actingAs($admin)->get(route('admin.ekstrakurikuler.index'));
        $response->assertOk();
        $response->assertSee('Daftar Kegiatan Ekstrakurikuler');
    }

    public function test_admin_without_permission_is_forbidden_from_ekstrakurikuler(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'permissions' => ['berita'],
        ]);

        $response = $this->actingAs($admin)->get(route('admin.ekstrakurikuler.index'));
        $response->assertForbidden();
    }

    public function test_can_create_ekstrakurikuler_with_logo_and_multiple_galeri(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create([
            'role' => 'admin',
            'permissions' => ['ekstrakurikuler'],
        ]);

        $logoFile = UploadedFile::fake()->image('basket_logo.png');
        $photo1 = UploadedFile::fake()->image('kegiatan1.jpg');
        $photo2 = UploadedFile::fake()->image('kegiatan2.jpg');

        $response = $this->actingAs($admin)->post(route('admin.ekstrakurikuler.store'), [
            'nama' => 'Bola Basket',
            'kategori' => 'Olahraga',
            'deskripsi' => 'Ekskul basket melatih fisik dan kerjasama tim.',
            'pembina' => 'Budi Santoso, S.Pd',
            'ketua' => 'Andi Wijaya',
            'hari' => 'Senin',
            'jam_mulai' => '15:30',
            'jam_selesai' => '17:30',
            'tempat' => 'Lapangan Basket Utama',
            'status' => 'aktif',
            'logo' => $logoFile,
            'galeri' => [$photo1, $photo2],
        ]);

        $response->assertRedirect(route('admin.ekstrakurikuler.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('ekstrakurikulers', [
            'nama' => 'Bola Basket',
            'kategori' => 'Olahraga',
            'pembina' => 'Budi Santoso, S.Pd',
            'status' => 'aktif',
        ]);

        $ekskul = Ekstrakurikuler::where('nama', 'Bola Basket')->first();
        $this->assertNotNull($ekskul->logo);
        $this->assertCount(2, $ekskul->galeri);

        Storage::disk('public')->assertExists($ekskul->logo);
        foreach ($ekskul->galeri as $path) {
            Storage::disk('public')->assertExists($path);
        }
    }

    public function test_can_update_ekstrakurikuler_and_manage_galeri(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create([
            'role' => 'admin',
            'permissions' => ['ekstrakurikuler'],
        ]);

        $photoOld = UploadedFile::fake()->image('old_photo.jpg')->store('uploads/ekskul/galeri', 'public');

        $ekskul = Ekstrakurikuler::create([
            'nama' => 'Pramuka',
            'kategori' => 'Lainnya',
            'deskripsi' => 'Gerakan Pramuka Gudep 01',
            'pembina' => 'Ahmad',
            'ketua' => 'Siti',
            'hari' => 'Jumat',
            'jam_mulai' => '14:00',
            'jam_selesai' => '16:00',
            'tempat' => 'Lapangan Utama',
            'status' => 'aktif',
            'galeri' => [$photoOld],
        ]);

        $newPhoto = UploadedFile::fake()->image('new_photo.jpg');

        $response = $this->actingAs($admin)->put(route('admin.ekstrakurikuler.update', $ekskul->id), [
            'nama' => 'Pramuka Update',
            'kategori' => 'Lainnya',
            'deskripsi' => 'Deskripsi baru',
            'status' => 'aktif',
            'deleted_galeri' => [$photoOld],
            'galeri' => [$newPhoto],
        ]);

        $response->assertRedirect(route('admin.ekstrakurikuler.index'));

        $ekskul->refresh();
        $this->assertEquals('Pramuka Update', $ekskul->nama);
        $this->assertCount(1, $ekskul->galeri);
        $this->assertNotContains($photoOld, $ekskul->galeri);

        // Old photo should be deleted from storage
        Storage::disk('public')->assertMissing($photoOld);
        // New photo exists
        Storage::disk('public')->assertExists($ekskul->galeri[0]);
    }

    public function test_can_delete_ekstrakurikuler_and_its_files(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create([
            'role' => 'admin',
            'permissions' => ['ekstrakurikuler'],
        ]);

        $logo = UploadedFile::fake()->image('logo.png')->store('uploads/ekskul', 'public');
        $photo = UploadedFile::fake()->image('photo.jpg')->store('uploads/ekskul/galeri', 'public');

        $ekskul = Ekstrakurikuler::create([
            'nama' => 'PMR',
            'kategori' => 'Keagamaan',
            'status' => 'aktif',
            'logo' => $logo,
            'galeri' => [$photo],
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.ekstrakurikuler.destroy', $ekskul->id));
        $response->assertRedirect(route('admin.ekstrakurikuler.index'));

        $this->assertDatabaseMissing('ekstrakurikulers', ['id' => $ekskul->id]);
        Storage::disk('public')->assertMissing($logo);
        Storage::disk('public')->assertMissing($photo);
    }

    public function test_public_can_view_ekstrakurikuler_list_and_detail(): void
    {
        $ekskul = Ekstrakurikuler::create([
            'nama' => 'KIR (Karya Ilmiah Remaja)',
            'kategori' => 'Akademik',
            'deskripsi' => 'Riset dan sains siswa',
            'status' => 'aktif',
        ]);

        // Public index
        $response = $this->get(route('frontend.ekstrakurikuler'));
        $response->assertOk();
        $response->assertSee('KIR (Karya Ilmiah Remaja)');

        // Public detail
        $response = $this->get(route('frontend.ekstrakurikuler.show', $ekskul->id));
        $response->assertOk();
        $response->assertSee('KIR (Karya Ilmiah Remaja)');
        $response->assertSee('Riset dan sains siswa');
    }
}
