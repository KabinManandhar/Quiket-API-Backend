<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Organizer extends Model
{
    public function events(){
        return $this->hasMany(Event::class);
    }
}
