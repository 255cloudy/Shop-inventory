<?php

namespace App\Models;

use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;
    protected $guarded = [];

    function entries(){
        return  $this->hasMany(order_entry::class, 'order_id');
    }

//    get the person who received the order
    function user()
    {
        return $this->belongsTo(User::class);
    }
    function  distributer() {
        return $this->belongsTo(distributer::class, "distributer_id");
    }
    protected static function newFactory()
    {
        return OrderFactory::new();
    }
}
