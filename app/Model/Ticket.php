<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable=['name','description','price','ticket_type','status','refundable','promo_code','start_datetime','end_datetime','max_ticket_allowed_per_person','min_ticket_allowed_per_person'];
    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }
}
