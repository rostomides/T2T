<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LookingFor extends Model
{
    public function profil(){
        return $this->belongsTo(Profil::class);
    }
}
