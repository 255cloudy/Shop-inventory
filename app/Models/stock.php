<?php

namespace App\Models;

use Database\Factories\StockFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stock extends Model
{
    use HasFactory;
    protected $table = "stocks";
    protected $guarded = [];

    public function product(){
        return $this->belongsTo(product::class, "product_id");
    }

    protected static function newFactory()
    {
        return StockFactory::new();
    }
}
