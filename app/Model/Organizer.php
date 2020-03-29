<?php

namespace App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\Token;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;

class Organizer extends Authenticatable
{
    protected $fillable=[
      'name','description','picture','email','password','phone_no'
    ];
    use HasMultiAuthApiTokens,Notifiable;
    public function events(){
        return $this->hasMany(Event::class);
    }
}
