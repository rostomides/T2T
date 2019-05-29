<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    public function profil(){
        return $this->belongsToMany(Profil::class);
    }
}
