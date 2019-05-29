<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountryGrewUp extends Model
{
    public function profile(){
        return $this->hasMany(Profil::class);
    }
}
