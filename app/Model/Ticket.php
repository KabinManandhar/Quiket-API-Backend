<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }
}
