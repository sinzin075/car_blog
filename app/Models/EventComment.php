<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventComment extends Model
{
    use HasFactory;
    protected $table = 'event_comment';
    
    public function Event(){
    return $this->belongsTo(Event::class);
    }
    
    public function User(){
        return $this->belongsTo(User::class);
    }
}
