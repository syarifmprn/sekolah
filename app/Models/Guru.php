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

    public function getFotoUrlAttribute(): ?string
    {
        return storage_upload_url($this->foto);
    }
}
