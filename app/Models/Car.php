<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    // 一括代入を許可する属性を指定
    protected $fillable = ['name', 'photo', 'maker_id'];

    // Maker モデルとのリレーションシップを定義
    public function maker()
    {
        return $this->belongsTo(Maker::class);
    }
}

