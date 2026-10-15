<?php

namespace Tests\Feature;

use App\Models\Prasarana;
use App\Models\Sarana;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SaranaPrasaranaTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_with_permission_can_access_prasarana_management(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'permissions' => ['prasarana'],
        ]);

        $response = $this->actingAs($admin)->get(route('admin.prasarana.index'));
        $response->assertOk();
        $response->assertSee('Daftar Prasarana Sekolah');

        // Blocked from sarana
        $responseSarana = $this->actingAs($admin)->get(route('admin.sarana.index'));
        $responseSarana->assertForbidden();
    }

    public function test_admin_with_permission_can_access_sarana_management(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'permissions' => ['sarana'],
        ]);

        $response = $this->actingAs($admin)->get(route('admin.sarana.index'));
        $response->assertOk();
        $response->assertSee('Daftar Sarana');

        // Blocked from prasarana
        $responsePrasarana = $this->actingAs($admin)->get(route('admin.prasarana.index'));
        $responsePrasarana->assertForbidden();
    }

    public function test_can_create_prasarana_with_photo(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create([
            'role' => 'admin',
            'permissions' => ['prasarana'],
        ]);

        $foto = UploadedFile::fake()->image('lab_komputer.jpg');

        $response = $this->actingAs($admin)->post(route('admin.prasarana.store'), [
            'nama' => 'Lab Komputer 1',
            'jumlah' => 2,
            'luas' => 72.50,
            'kondisi' => 'baik',
            'keterangan' => 'Dilengkapi 30 unit komputer dan proyektor.',
            'foto' => $foto,
        ]);

        $response->assertRedirect(route('admin.prasarana.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('prasaranas', [
            'nama' => 'Lab Komputer 1',
            'jumlah' => 2,
            'kondisi' => 'baik',
        ]);

        $prasarana = Prasarana::where('nama', 'Lab Komputer 1')->first();
        $this->assertNotNull($prasarana->foto);
        Storage::disk('public')->assertExists($prasarana->foto);
    }

    public function test_can_create_sarana_associated_with_prasarana(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create([
            'role' => 'admin',
            'permissions' => ['sarana'],
        ]);

        $prasarana = Prasarana::create([
            'nama' => 'Aula Utama',
            'jumlah' => 1,
            'luas' => 300,
            'kondisi' => 'baik',
        ]);

        $foto = UploadedFile::fake()->image('proyektor.png');

        $response = $this->actingAs($admin)->post(route('admin.sarana.store'), [
            'nama' => 'Proyektor Epson',
            'prasarana_id' => $prasarana->id,
            'jumlah' => 2,
            'kondisi' => 'baik',
            'tahun_pengadaan' => 2024,
            'keterangan' => 'Kondisi normal terpasang di plafon aula.',
            'foto' => $foto,
        ]);

        $response->assertRedirect(route('admin.sarana.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('saranas', [
            'nama' => 'Proyektor Epson',
            'prasarana_id' => $prasarana->id,
            'jumlah' => 2,
            'kondisi' => 'baik',
            'tahun_pengadaan' => 2024,
        ]);

        $sarana = Sarana::where('nama', 'Proyektor Epson')->first();
        $this->assertNotNull($sarana->foto);
        Storage::disk('public')->assertExists($sarana->foto);
        $this->assertEquals($prasarana->id, $sarana->prasarana->id);
    }

    public function test_can_update_and_delete_prasarana_and_sarana(): void
    {
        Storage::fake('public');

        $superadmin = User::factory()->create(['role' => 'superadmin']);

        $fotoPrasarana = UploadedFile::fake()->image('room.jpg')->store('uploads/prasarana', 'public');
        $prasarana = Prasarana::create([
            'nama' => 'Ruang UKS',
            'jumlah' => 1,
            'luas' => 24,
            'kondisi' => 'baik',
            'foto' => $fotoPrasarana,
        ]);

        $fotoSarana = UploadedFile::fake()->image('bed.jpg')->store('uploads/sarana', 'public');
        $sarana = Sarana::create([
            'nama' => 'Tempat Tidur Pasien',
            'prasarana_id' => $prasarana->id,
            'jumlah' => 3,
            'kondisi' => 'baik',
            'tahun_pengadaan' => 2023,
            'foto' => $fotoSarana,
        ]);

        // Update prasarana
        $response = $this->actingAs($superadmin)->put(route('admin.prasarana.update', $prasarana->id), [
            'nama' => 'Ruang UKS Terpadu',
            'jumlah' => 2,
            'luas' => 48,
            'kondisi' => 'rusak_ringan',
        ]);
        $response->assertRedirect(route('admin.prasarana.index'));
        $prasarana->refresh();
        $this->assertEquals('Ruang UKS Terpadu', $prasarana->nama);
        $this->assertEquals('rusak_ringan', $prasarana->kondisi);

        // Delete sarana
        $this->actingAs($superadmin)->delete(route('admin.sarana.destroy', $sarana->id))
            ->assertRedirect(route('admin.sarana.index'));
        $this->assertDatabaseMissing('saranas', ['id' => $sarana->id]);
        Storage::disk('public')->assertMissing($fotoSarana);

        // Delete prasarana
        $this->actingAs($superadmin)->delete(route('admin.prasarana.destroy', $prasarana->id))
            ->assertRedirect(route('admin.prasarana.index'));
        $this->assertDatabaseMissing('prasaranas', ['id' => $prasarana->id]);
        Storage::disk('public')->assertMissing($fotoPrasarana);
    }

    public function test_public_can_view_sarana_prasarana_page(): void
    {
        Prasarana::create([
            'nama' => 'Perpustakaan Digital',
            'jumlah' => 1,
            'luas' => 150,
            'kondisi' => 'baik',
            'keterangan' => 'Fasilitas perpustakaan lengkap dengan e-library.',
        ]);

        $response = $this->get(route('frontend.sarpras'));
        $response->assertOk();
        $response->assertSee('Perpustakaan Digital');
        $response->assertSee('Sarana & Prasarana');
    }
}
