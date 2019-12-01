<?php

namespace App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;

class Organizer extends Authenticatable
{
    use HasMultiAuthApiTokens,Notifiable;
    public function events(){
        return $this->hasMany(Event::class);
    }
}
