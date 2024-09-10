<?php

namespace App\Models;

use Database\Factories\SaleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sale extends Model
{
    use HasFactory;
    protected $guarded = [];

     public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(){
        return $this->belongsTo(product::class, "product_id");
    }

    protected static function newFactory(): SaleFactory
    {
         return SaleFactory::new();
    }
}
