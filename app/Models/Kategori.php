<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    //

    // Kategori.php
    public function materi()
    {
        return $this->hasMany(Material::class);
    }
}
