<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $guarded = [];
    use HasFactory;

    function Product(){
        return $this->belongsTo(product::class);
    }

}
