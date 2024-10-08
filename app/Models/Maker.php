<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maker extends Model
{
    use HasFactory;
    
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    
    public function car()
    {
        return $this->hasMany(Car::class);
    }
}
