<?php

namespace App\Models;

use Database\Factories\ExpensesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class expense extends Model
{
    use HasFactory;
    protected $fillable = ["name", "amount", "category_id", "recurring"];

    protected static function newFactory()
    {
        return ExpensesFactory::new();
    }

    public function category(){
        return $this->belongsTo(categories::class, "category_id");
    }
}
