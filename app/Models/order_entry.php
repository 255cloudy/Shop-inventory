<?php

namespace App\Models;

use Database\Factories\OrderEntryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_entry extends Model
{
    use HasFactory;
    protected $table = "order_entry";
    protected $guarded = [];
    public function order()
    {
        return $this->belongsTo(order::class, 'order_id');
    }

    public function  product(){
        return $this->belongsTo(product::class, "product_id");
    }
    protected static function newFactory()
    {
        return OrderEntryFactory::new();
    }
}
