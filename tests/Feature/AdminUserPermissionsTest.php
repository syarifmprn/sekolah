<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserPermissionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_superadmin_can_access_user_management(): void
    {
        $superadmin = User::factory()->create(['role' => 'superadmin']);

        $response = $this->actingAs($superadmin)->get(route('admin.user.index'));
        $response->assertOk();
        $response->assertSee('Daftar Pengguna Sistem');
    }

    public function test_regular_admin_cannot_access_user_management(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'permissions' => ['berita', 'prestasi'],
        ]);

        $response = $this->actingAs($admin)->get(route('admin.user.index'));
        $response->assertForbidden();
    }

    public function test_superadmin_can_create_admin_with_specific_permissions(): void
    {
        $superadmin = User::factory()->create(['role' => 'superadmin']);

        $response = $this->actingAs($superadmin)->post(route('admin.user.store'), [
            'name' => 'Admin Berita',
            'email' => 'adminberita@sekolah.sch.id',
            'password' => 'secret123',
            'role' => 'admin',
            'permissions' => ['berita', 'pengumuman'],
        ]);

        $response->assertRedirect(route('admin.user.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'adminberita@sekolah.sch.id',
            'role' => 'admin',
        ]);

        $createdUser = User::where('email', 'adminberita@sekolah.sch.id')->first();
        $this->assertTrue($createdUser->hasPermission('berita'));
        $this->assertTrue($createdUser->hasPermission('pengumuman'));
        $this->assertFalse($createdUser->hasPermission('guru'));
    }

    public function test_superadmin_can_update_admin_permissions(): void
    {
        $superadmin = User::factory()->create(['role' => 'superadmin']);
        $admin = User::factory()->create([
            'role' => 'admin',
            'permissions' => ['berita'],
        ]);

        $response = $this->actingAs($superadmin)->put(route('admin.user.update', $admin->id), [
            'name' => 'Admin Updated',
            'email' => $admin->email,
            'role' => 'admin',
            'permissions' => ['guru', 'galeri', 'prestasi'],
        ]);

        $response->assertRedirect(route('admin.user.index'));
        $admin->refresh();
        $this->assertFalse($admin->hasPermission('berita'));
        $this->assertTrue($admin->hasPermission('guru'));
        $this->assertTrue($admin->hasPermission('galeri'));
        $this->assertTrue($admin->hasPermission('prestasi'));
    }

    public function test_admin_with_permission_can_access_module_and_is_blocked_from_unauthorized_module(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'permissions' => ['berita'],
        ]);

        // Allowed to access berita
        $response = $this->actingAs($admin)->get(route('admin.berita.index'));
        $response->assertOk();

        // Blocked from accessing guru
        $response = $this->actingAs($admin)->get(route('admin.guru.index'));
        $response->assertForbidden();

        // Blocked from accessing pengaturan website
        $response = $this->actingAs($admin)->get(route('admin.pengaturan-website.index'));
        $response->assertForbidden();
    }

    public function test_superadmin_has_full_access_to_all_modules(): void
    {
        $superadmin = User::factory()->create(['role' => 'superadmin']);

        $this->actingAs($superadmin)->get(route('admin.berita.index'))->assertOk();
        $this->actingAs($superadmin)->get(route('admin.guru.index'))->assertOk();
        $this->actingAs($superadmin)->get(route('admin.galeri.index'))->assertOk();
        $this->actingAs($superadmin)->get(route('admin.menu.index'))->assertOk();
        $this->actingAs($superadmin)->get(route('admin.pengaturan-website.index'))->assertOk();
    }

    public function test_navigation_renders_only_permitted_menus_for_admin(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'permissions' => ['berita'],
        ]);

        $response = $this->actingAs($admin)->get(route('dashboard'));
        $response->assertOk();
        $response->assertSee(route('admin.berita.index'));
        $response->assertDontSee(route('admin.guru.index'));
        $response->assertDontSee(route('admin.user.index'));
    }
}
