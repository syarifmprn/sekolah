<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    protected $table = 'prestasis';

    protected $fillable = ['nama_kegiatan', 'hasil', 'tahun', 'tipe', 'dokumentasi'];

    protected function casts(): array
    {
        return [
            'dokumentasi' => 'array',
        ];
    }

    //
}
