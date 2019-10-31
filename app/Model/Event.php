<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function organizer(){
        return $this->belongsTo(Organizer::class);
    }

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }
}
