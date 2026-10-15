<?php

namespace Tests\Feature;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GuruTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_with_permission_can_access_guru_management(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'permissions' => ['guru'],
        ]);

        Guru::create([
            'nama' => 'Drs. H. Ahmad Wijaya, M.Pd.',
            'jabatan' => 'Guru Matematika',
            'nip' => '197501012000031001',
            'aktif' => true,
            'jenis_kelamin' => 'L',
            'agama' => 'Islam',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.guru.index'));
        $response->assertOk();
        $response->assertSee('Daftar Guru & Tenaga Kependidikan', false);
        $response->assertSee('Drs. H. Ahmad Wijaya, M.Pd.');
        $response->assertSee('Guru Matematika');
        $response->assertSee('Total Guru');
        $response->assertSee('Guru Aktif');
    }

    public function test_admin_can_filter_guru_by_search_and_status(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'permissions' => ['guru'],
        ]);

        Guru::create([
            'nama' => 'Siti Nurhaliza, S.Pd.',
            'jabatan' => 'Guru Bahasa Inggris',
            'nip' => '198802022010012002',
            'aktif' => true,
            'jenis_kelamin' => 'P',
        ]);

        Guru::create([
            'nama' => 'Bambang Sutrisno, S.Kom.',
            'jabatan' => 'Guru Informatika',
            'nip' => '199003032015011003',
            'aktif' => false,
            'jenis_kelamin' => 'L',
        ]);

        // Search test
        $response = $this->actingAs($admin)->get(route('admin.guru.index', ['search' => 'Nurhaliza']));
        $response->assertOk();
        $response->assertSee('Siti Nurhaliza, S.Pd.');
        $response->assertDontSee('Bambang Sutrisno, S.Kom.');

        // Filter status test
        $responseStatus = $this->actingAs($admin)->get(route('admin.guru.index', ['status' => 'nonaktif']));
        $responseStatus->assertOk();
        $responseStatus->assertSee('Bambang Sutrisno, S.Kom.');
        $responseStatus->assertDontSee('Siti Nurhaliza, S.Pd.');
    }
}
