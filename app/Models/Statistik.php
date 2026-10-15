<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statistik extends Model
{
    protected $table = 'statistiks';
    protected $fillable = ['nama', 'icon', 'value'];
}
