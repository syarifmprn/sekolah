<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekstrakurikuler extends Model
{
    use HasFactory;

    protected $table = 'ekstrakurikulers';

    protected $fillable = [
        'nama',
        'kategori',
        'deskripsi',
        'logo',
        'galeri',
        'pembina',
        'ketua',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'tempat',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'galeri' => 'array',
        ];
    }

    /**
     * Daftar kategori ekstrakurikuler yang tersedia.
     */
    public static function kategoriList(): array
    {
        return [
            'Olahraga',
            'Seni',
            'Akademik',
            'Keagamaan',
            'Lainnya',
        ];
    }

    /**
     * Daftar hari latihan.
     */
    public static function hariList(): array
    {
        return [
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
            'Minggu',
        ];
    }

    /**
     * Scope untuk mengambil ekskul yang aktif saja.
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Accessor URL logo.
     */
    public function getLogoUrlAttribute(): ?string
    {
        if (!$this->logo) {
            return null;
        }

        return asset('storage/' . $this->logo);
    }

    /**
     * Accessor list URL galeri foto.
     */
    public function getGaleriUrlsAttribute(): array
    {
        if (!is_array($this->galeri) || empty($this->galeri)) {
            return [];
        }

        return array_map(function ($item) {
            return asset('storage/' . $item);
        }, $this->galeri);
    }

    /**
     * Format jadwal lengkap.
     */
    public function getJadwalFormattedAttribute(): string
    {
        $jadwal = [];
        if ($this->hari) {
            $jadwal[] = $this->hari;
        }

        if ($this->jam_mulai && $this->jam_selesai) {
            $mulai = substr($this->jam_mulai, 0, 5);
            $selesai = substr($this->jam_selesai, 0, 5);
            $jadwal[] = "{$mulai} - {$selesai}";
        } elseif ($this->jam_mulai) {
            $mulai = substr($this->jam_mulai, 0, 5);
            $jadwal[] = "Mulai {$mulai}";
        }

        return !empty($jadwal) ? implode(', ', $jadwal) : '-';
    }
}
