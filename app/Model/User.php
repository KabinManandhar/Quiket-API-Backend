<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function orders(){
        return $this->hasMany(Order::class);
    }
    public function bookmarks(){
        return $this->hasMany(Bookmark::class);
    }
}
