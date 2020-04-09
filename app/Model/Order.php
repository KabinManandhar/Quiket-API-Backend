<?php

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable=['status','ticket_id','user_id','qr_code'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function ticket(){
        return $this->belongsTo(Ticket::class);
    }
}
