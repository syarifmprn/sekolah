<?php

namespace Tests\Feature;

use App\Models\Alumni;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AlumniTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_with_permission_can_access_alumni_management(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'permissions' => ['alumni'],
        ]);

        $response = $this->actingAs($admin)->get(route('admin.alumni.index'));
        $response->assertOk();
        $response->assertSee('Daftar Alumni');
    }

    public function test_admin_without_permission_is_forbidden(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'permissions' => ['berita'],
        ]);

        $response = $this->actingAs($admin)->get(route('admin.alumni.index'));
        $response->assertForbidden();
    }

    public function test_can_create_alumni_with_photo(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create([
            'role' => 'admin',
            'permissions' => ['alumni'],
        ]);

        $foto = UploadedFile::fake()->image('alumni.jpg');

        $response = $this->actingAs($admin)->post(route('admin.alumni.store'), [
            'nama' => 'Budi Santoso',
            'tahun_lulus' => 2018,
            'jurusan' => 'MIPA',
            'foto' => $foto,
            'pekerjaan' => 'Software Engineer',
            'instansi' => 'Google Indonesia',
            'alamat' => 'Jakarta Selatan',
            'no_hp' => '081234567890',
            'email' => 'budi@example.com',
            'testimoni' => 'Sekolah ini memberikan fondasi berpikir logis dan disiplin yang kuat.',
            'tampil' => 'ya',
        ]);

        $response->assertRedirect(route('admin.alumni.index'));

        $this->assertDatabaseHas('alumnis', [
            'nama' => 'Budi Santoso',
            'tahun_lulus' => 2018,
            'pekerjaan' => 'Software Engineer',
            'instansi' => 'Google Indonesia',
            'tampil' => 'ya',
        ]);

        $alumni = Alumni::where('nama', 'Budi Santoso')->first();
        $this->assertNotNull($alumni->foto);
        Storage::disk('public')->assertExists($alumni->foto);
    }

    public function test_can_update_alumni_and_replace_photo(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create([
            'role' => 'admin',
            'permissions' => ['alumni'],
        ]);

        $oldPhoto = UploadedFile::fake()->image('old.jpg')->store('uploads/alumni', 'public');

        $alumni = Alumni::create([
            'nama' => 'Siti Rahma',
            'tahun_lulus' => 2019,
            'jurusan' => 'IPS',
            'foto' => $oldPhoto,
            'pekerjaan' => 'Banker',
            'instansi' => 'Bank Mandiri',
            'alamat' => 'Bandung',
            'no_hp' => '081298765432',
            'email' => 'siti@example.com',
            'testimoni' => 'Guru-gurunya sangat suportif dan berdedikasi tinggi.',
            'tampil' => 'ya',
        ]);

        $newPhoto = UploadedFile::fake()->image('new.jpg');

        $response = $this->actingAs($admin)->put(route('admin.alumni.update', $alumni->id), [
            'nama' => 'Siti Rahma, S.E.',
            'tahun_lulus' => 2019,
            'jurusan' => 'IPS',
            'foto' => $newPhoto,
            'pekerjaan' => 'Senior Banker',
            'instansi' => 'Bank Mandiri Pusat',
            'alamat' => 'Jakarta Pusat',
            'no_hp' => '081298765432',
            'email' => 'siti@example.com',
            'testimoni' => 'Pengalaman belajar yang berharga dan relevan di dunia kerja.',
            'tampil' => 'ya',
        ]);

        $response->assertRedirect(route('admin.alumni.index'));

        $this->assertDatabaseHas('alumnis', [
            'id' => $alumni->id,
            'nama' => 'Siti Rahma, S.E.',
            'pekerjaan' => 'Senior Banker',
        ]);

        Storage::disk('public')->assertMissing($oldPhoto);
        $alumni->refresh();
        Storage::disk('public')->assertExists($alumni->foto);
    }

    public function test_can_delete_alumni_and_photo(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create([
            'role' => 'admin',
            'permissions' => ['alumni'],
        ]);

        $photo = UploadedFile::fake()->image('alumni_hapus.jpg')->store('uploads/alumni', 'public');

        $alumni = Alumni::create([
            'nama' => 'Ahmad Dani',
            'tahun_lulus' => 2015,
            'jurusan' => 'IPA',
            'foto' => $photo,
            'pekerjaan' => 'Dokter',
            'instansi' => 'RSUD',
            'testimoni' => 'Terima kasih atas bimbingan para guru.',
            'tampil' => 'ya',
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.alumni.destroy', $alumni->id));
        $response->assertRedirect(route('admin.alumni.index'));

        $this->assertDatabaseMissing('alumnis', ['id' => $alumni->id]);
        Storage::disk('public')->assertMissing($photo);
    }

    public function test_public_can_view_alumni_directory_and_testimonials(): void
    {
        Alumni::create([
            'nama' => 'Alumni Tampil',
            'tahun_lulus' => 2020,
            'jurusan' => 'MIPA',
            'pekerjaan' => 'Data Analyst',
            'instansi' => 'Shopee',
            'testimoni' => 'Sekolah yang sangat menginspirasi masa depan.',
            'tampil' => 'ya',
        ]);

        Alumni::create([
            'nama' => 'Alumni Tidak Tampil',
            'tahun_lulus' => 2021,
            'jurusan' => 'IPS',
            'pekerjaan' => 'Freelancer',
            'instansi' => 'Self-employed',
            'testimoni' => 'Testimoni rahasia internal.',
            'tampil' => 'tidak',
        ]);

        $response = $this->get(route('frontend.alumni'));
        $response->assertOk();
        $response->assertSee('Alumni Tampil');
        $response->assertDontSee('Alumni Tidak Tampil');
    }

    public function test_public_can_submit_alumni_story(): void
    {
        Storage::fake('public');

        $foto = UploadedFile::fake()->image('submission.jpg');

        $response = $this->post(route('frontend.alumni.store'), [
            'nama' => 'Rizky Pratama',
            'tahun_lulus' => 2022,
            'jurusan' => 'RPL',
            'foto' => $foto,
            'pekerjaan' => 'Mobile Developer',
            'instansi' => 'Startup Tech',
            'alamat' => 'Yogyakarta',
            'no_hp' => '08987654321',
            'email' => 'rizky@startup.io',
            'testimoni' => 'Pendidikan di sekolah ini membuka banyak peluang karir di industri kreatif.',
        ]);

        $response->assertRedirect(route('frontend.alumni'));

        // Harusnya default tampil 'tidak' sampai disetujui admin
        $this->assertDatabaseHas('alumnis', [
            'nama' => 'Rizky Pratama',
            'tahun_lulus' => 2022,
            'tampil' => 'tidak',
        ]);
    }
}
