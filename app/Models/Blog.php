<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'body',
        'photo',
    ];
    
    public function User(){
        return $this->belongsTo(User::class);
    }
    
    public function Blogcomments(){
        return $this->hasMany(BlogComment::class);
    }
    
    public function likes()
    {
        return $this->hasMany(Likes::class);
    }

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'likes');
    }
}
