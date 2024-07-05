<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    
     public function Blog(){
        return $this -> belongsTo(Blog::class);
    }
    
    public function Event(){
        return $this -> belongsTo(Event::class);
    }
}
