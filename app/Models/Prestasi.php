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

    public function getFirstDokumentasiUrlAttribute(): ?string
    {
        if (!$this->dokumentasi || !is_array($this->dokumentasi) || empty($this->dokumentasi[0])) {
            return null;
        }

        return storage_upload_url($this->dokumentasi[0]);
    }
}
