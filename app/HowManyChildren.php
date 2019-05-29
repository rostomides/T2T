<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HowManyChildren extends Model
{
    public function profil(){
        return $this->hasMany(Profil::class);
    }
}
