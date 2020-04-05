<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable=['name','description','category','picture','type','venue','status','start_datetime','end_datetime','organizer_id'];

    public function organizer(){
        return $this->belongsTo(Organizer::class);
    }

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }

    public function bookmark(){
        return $this->belongsTo(Bookmark::class);
    }

    public function orders(){
        return $this->hasManyThrough(Order::class, Ticket::class);
    }
}
