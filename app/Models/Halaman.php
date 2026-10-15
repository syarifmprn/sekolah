<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Halaman extends Model
{
    protected $table = 'halamans';

    protected $fillable = ['judul', 'slug', 'tanggal', 'isi', 'thumbnail'];


    //
}
