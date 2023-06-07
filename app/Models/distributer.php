<?php

namespace App\Models;

use Database\Factories\DistributerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class distributer extends Model
{
    use HasFactory;
    protected $guarded = [];

    function orders(){
        return $this->hasMany(Order::class, 'dstributer_id');
    }

    protected static function newFactory()
    {
        return DistributerFactory::new();
    }
}
