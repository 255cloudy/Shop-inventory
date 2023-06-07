<?php

namespace App\Models;

use Database\Factories\CategoriesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
    use HasFactory;
    protected $fillable = ["name", "description"];
    function expenses(){
        return $this->hasMany(expense::class, "category_id");
    }

    protected static function newFactory()
    {
        return CategoriesFactory::new();
    }
}
