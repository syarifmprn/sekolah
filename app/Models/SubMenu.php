<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    protected $table = 'sub_menus';

    protected $fillable = ['menu_id', 'nama_menu', 'link'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    //
}
