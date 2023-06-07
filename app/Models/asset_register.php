<?php

namespace App\Models;

use Database\Factories\AssetRegisterFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class asset_register extends Model
{
    protected $table = "asset_register";
    use HasFactory;
    protected $fillable = ["name", "condition", "qty"];

    protected static function newFactory(){
        return AssetRegisterFactory::new();
    }
}
