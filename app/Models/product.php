<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    protected $fillable = ["name", "description"];
    use HasFactory;

    function sales() {
        return $this->hasMany(sale::class, "product_id");
    }
    function order_entries(){
        return $this->hasMany(order_entry::class, "product_id");
    }
    function stock(){
        return $this->hasOne(stock::class, "product_id");
    }
    function price() {
        return $this->hasOne(Price::class, "product_id");
    }

    protected static function newFactory()
    {
        return ProductFactory::new();
    }
}
