<?php

namespace App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;

class User extends Authenticatable
{
    use Notifiable,HasMultiAuthApiTokens;
    /**
     * @var array
     */
    protected $fillable=['first_name','last_name','email','password'];
    protected $hidden= ['password'];

    public function orders(){
        return $this->hasMany(Order::class);
    }
    public function bookmarks(){
        return $this->hasMany(Bookmark::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
