<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    public function UserStatus(){
        return $this -> hasOne(UserStatus::class);
    }
    
    public function Blog(){
        return $this -> hasMany(Blog::class);
    }
    public function BlogComment(){
        return $this -> hasMany(BlogComment::class);
    }
    public function Event(){
        return $this -> hasMany(Event::class);
    }
    
    public function likes()
    {
        return $this->hasMany(Likes::class);
    }

    public function likedBlogs()
    {
        return $this->belongsToMany(Blog::class, 'likes');
    }
    
    public function follows(){//ユーザーがフォローしているほかのユーザーを取得
        return $this->belongsToMany(User::class,'follows','follower_id','followed_id');
    }

    public function followers(){//ユーザーをフォローしているほかのユーザーを取得
        return $this->belongsToMany(User::class,'follows','followed_id','follower_id');
    }
    
    public function cars(){//ユーザーをフォローしているほかのユーザーを取得
        return $this->belongsToMany(Car::class);
    }
}
