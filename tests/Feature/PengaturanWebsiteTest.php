<?php

namespace Tests\Feature;

use App\Models\PengaturanWebsite;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PengaturanWebsiteTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_upload_and_display_logo(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'role' => 'admin',
            'permissions' => ['pengaturan-website'],
        ]);

        $file = UploadedFile::fake()->image('sekolah_logo.png');

        $response = $this->actingAs($user)->post(route('admin.pengaturan-website.update'), [
            'nama_sekolah' => 'SMAN 1 Test',
            'logo' => $file,
        ]);

        $response->assertSessionHas('success');

        $pengaturan = PengaturanWebsite::first();
        $this->assertNotNull($pengaturan);
        $this->assertNotNull($pengaturan->logo);

        // Assert file exists on public disk
        Storage::disk('public')->assertExists('uploads/' . $pengaturan->logo);

        // Test removing logo
        $response = $this->actingAs($user)->post(route('admin.pengaturan-website.update'), [
            'nama_sekolah' => 'SMAN 1 Test',
            'remove_logo' => '1',
        ]);

        $pengaturan->refresh();
        $this->assertNull($pengaturan->logo);
    }
}
