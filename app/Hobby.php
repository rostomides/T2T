<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hobby extends Model
{
    public function profil(){
        return $this->belongsToMany(Profil::class);
    }

}
