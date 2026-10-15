<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $table = 'beritas';

    protected $fillable = ['judul', 'slug', 'tanggal', 'isi', 'thumbnail'];

    public function getThumbnailUrlAttribute(): ?string
    {
        return storage_upload_url($this->thumbnail);
    }
}
