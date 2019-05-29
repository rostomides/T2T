<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    public function profile(){
        return $this->belongsTo(Profil::class);
    }
}
