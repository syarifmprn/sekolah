<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'permissions'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'permissions' => 'array',
        ];
    }

    /**
     * Check if user has specific permission.
     */
    public function hasPermission(string $permission): bool
    {
        if ($this->role === 'superadmin') {
            return true;
        }

        if ($this->role !== 'admin') {
            return false;
        }

        if (!is_array($this->permissions)) {
            return false;
        }

        return in_array($permission, $this->permissions);
    }

    /**
     * Check if user has any of the given permissions.
     */
    public function hasAnyPermission(array $permissions): bool
    {
        if ($this->role === 'superadmin') {
            return true;
        }

        if ($this->role !== 'admin') {
            return false;
        }

        if (!is_array($this->permissions)) {
            return false;
        }

        return !empty(array_intersect($permissions, $this->permissions));
    }

    /**
     * List of all modules that can be permitted to admin.
     */
    public static function availablePermissions(): array
    {
        return [
            'berita' => [
                'label' => 'Berita',
                'desc' => 'Kelola artikel & berita sekolah',
                'icon' => 'fa-newspaper',
            ],
            'prestasi' => [
                'label' => 'Prestasi',
                'desc' => 'Kelola prestasi siswa & sekolah',
                'icon' => 'fa-trophy',
            ],
            'pengumuman' => [
                'label' => 'Pengumuman',
                'desc' => 'Kelola pengumuman & edaran',
                'icon' => 'fa-bullhorn',
            ],
            'guru' => [
                'label' => 'Guru & Tenaga Pendidik',
                'desc' => 'Kelola profil guru dan staf',
                'icon' => 'fa-chalkboard-user',
            ],
            'galeri' => [
                'label' => 'Galeri Foto',
                'desc' => 'Kelola album & foto dokumentasi',
                'icon' => 'fa-images',
            ],
            'halaman' => [
                'label' => 'Halaman Statis',
                'desc' => 'Kelola halaman profil & informasi',
                'icon' => 'fa-file-lines',
            ],
            'statistik' => [
                'label' => 'Statistik',
                'desc' => 'Kelola data statistik sekolah',
                'icon' => 'fa-chart-pie',
            ],
            'ekstrakurikuler' => [
                'label' => 'Ekstrakurikuler',
                'desc' => 'Kelola ekskul, jadwal latihan, pembina, & galeri',
                'icon' => 'fa-people-group',
            ],
            'prasarana' => [
                'label' => 'Prasarana (Ruangan)',
                'desc' => 'Kelola gedung, ruang kelas, lab, aula, & fasilitas fisik',
                'icon' => 'fa-building',
            ],
            'sarana' => [
                'label' => 'Sarana (Aset & Barang)',
                'desc' => 'Kelola inventaris alat, perlengkapan, & kondisi barang',
                'icon' => 'fa-boxes-stacked',
            ],
            'alumni' => [
                'label' => 'Direktori Alumni',
                'desc' => 'Kelola database alumni, angkatan, profesi, & testimoni',
                'icon' => 'fa-user-graduate',
            ],
            'menu' => [
                'label' => 'Menu Navigasi',
                'desc' => 'Kelola menu header/navbar website',
                'icon' => 'fa-bars',
            ],
            'sub-menu' => [
                'label' => 'Sub Menu',
                'desc' => 'Kelola sub menu navigasi website',
                'icon' => 'fa-layer-group',
            ],
            'pengaturan-website' => [
                'label' => 'Pengaturan Website',
                'desc' => 'Kelola identitas, logo, slider hero & kontak',
                'icon' => 'fa-sliders',
            ],
        ];
    }
}
