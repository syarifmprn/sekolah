<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanWebsite extends Model
{
    protected $table = 'pengaturan_websites';
    
    protected $fillable = [
        'nama_sekolah',
        'logo',
        'nama_kepala_sekolah',
        'foto_kepala_sekolah',
        'sambutan_kepala_sekolah',
        'alamat',
        'telefon',
        'email',
        'facebook',
        'instagram',
        'tiktok',
        'youtube',
        'titik_koordinat',
        'slider_hero',
        'akreditasi'
    ];

    protected $casts = [
        'slider_hero' => 'array'
    ];
}
