<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    
    public function User(){
        return $this->belongsTo(User::class);
    }
    
    public function EventComment(){
        return $this->hasMany(EventComment::class);
    }
    
        
    public function Event_likes()
    {
        return $this->hasMany(Event_Likes::class);
    }
    
    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'Event_likes');
    }
}
