<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model
{
    use HasFactory;
    protected $table = 'users_status';//テーブル指定
    protected $primaryKey = 'user_id';//主キー指定
    public $incrementing = 'false';//主キー自動増分を否定
    
    public function user(){//usersテーブルに属する
        return $this->belongsTo(user::class);
    }
    
    public function Car(){
        return $this -> hasMany(Car::class);
    }
    
}
