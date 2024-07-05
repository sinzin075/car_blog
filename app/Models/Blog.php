<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    
    public function User(){
        return $this->belongsto(User::class);
    }
    
    public function BlogComment(){
        return $this->hasMany(BlogComment::class);
    }
}
