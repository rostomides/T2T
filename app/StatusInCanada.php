<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusInCanada extends Model
{
    
    public function profil(){
        return $this->hasMany(Profil::class);
    }



}
