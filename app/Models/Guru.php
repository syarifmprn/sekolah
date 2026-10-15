<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'gurus';

    protected $fillable = [
        'nama', 'jabatan', 'foto', 'nip', 'nuptk', 
        'aktif', 'jenis_kelamin', 'agama', 'alamat', 
        'facebook', 'instagram', 'whatsapp'
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function getFotoUrlAttribute()
    {
        if (!$this->foto) {
            return null;
        }

        if (str_starts_with($this->foto, 'http://') || str_starts_with($this->foto, 'https://')) {
            return $this->foto;
        }

        return asset('storage/' . $this->foto);
    }
}
