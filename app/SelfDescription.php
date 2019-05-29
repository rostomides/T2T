<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SelfDescription extends Model
{
    public function profil(){
        return $this->belongsTo(Profil::class);
    }
}
