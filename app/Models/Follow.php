<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;
    
    public function follower(){
        return $this->belongsTo(User::class,'follows','followed_id');
    }

    public function followed(){
        return $this->belongsTo(User::class,'follows','follower_id');
    }
}
