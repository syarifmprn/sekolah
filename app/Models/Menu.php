<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';

    protected $fillable = ['nama_menu', 'link'];

    public function subMenus()
    {
        return $this->hasMany(SubMenu::class);
    }

    //
}
