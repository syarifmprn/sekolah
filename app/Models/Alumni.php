<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;

    protected $table = 'alumnis';

    protected $fillable = [
        'nama',
        'tahun_lulus',
        'jurusan',
        'foto',
        'pekerjaan',
        'instansi',
        'alamat',
        'no_hp',
        'email',
        'testimoni',
        'tampil',
    ];

    protected function casts(): array
    {
        return [
            'tahun_lulus' => 'integer',
        ];
    }

    /**
     * Scope untuk mengambil alumni yang disetujui tampil di website.
     */
    public function scopeTampil($query)
    {
        return $query->where('tampil', 'ya');
    }

    /**
     * Accessor URL foto alumni.
     */
    public function getFotoUrlAttribute(): ?string
    {
        if (!$this->foto) {
            return null;
        }

        if (str_starts_with($this->foto, 'http://') || str_starts_with($this->foto, 'https://')) {
            return $this->foto;
        }

        return asset('storage/' . ltrim($this->foto, '/'));
    }
}
