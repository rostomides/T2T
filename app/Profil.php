<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }


    public function sex(){
        return $this->belongsTo(Sex::class);
    }

    public function statusincanada(){
        return $this->belongsTo(StatusInCanada::class);
    }

    public function location(){
        return $this->belongsTo(Location::class);
    }

    public function maritalstatus(){
        return $this->belongsTo(MaritalStatus::class);
    }

    public function howmanychildren(){
        return $this->belongsTo(HowManyChildren::class);
    }

    public function childrenwithyou(){
        return $this->belongsTo(ChildrenWithYou::class);
    }

    public function education(){
        return $this->belongsTo(Education::class);
    }

    public function bodytype(){
        return $this->belongsTo(BodyType::class);
    }

    public function dress(){
        return $this->belongsTo(Dress::class);
    }

    public function profession(){
        return $this->belongsTo(Profession::class);
    }

    public function selfdescription(){
        return $this->hasOne(SelfDescription::class);
    }

    public function lookingfor(){
        return $this->hasOne(LookingFor::class);
    }

    public function ethnicity(){
        return $this->belongsTo(Ethnicity::class);
    }

    public function countrygrewup(){
        return $this->belongsTo(CountryGrewUp::class);
    }

    public function hobbies(){
        return $this->belongsToMany(Hobby::class);
    }

    public function languages(){
        return $this->belongsToMany(Language::class);
    }

    public function interview(){
        return $this->hasOne(Interview::class);
    }

    public function pictures(){
        return $this->hasMany(Picture::class);
    }
}
