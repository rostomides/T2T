<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Attribute Role
    public function role(){
        return $this->belongsTo(Role::class);
    }


    public function status(){
        return $this->belongsTo(Status::class);
    }

    public function profile(){
        return $this->hasOne(Profil::class);
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }
}
