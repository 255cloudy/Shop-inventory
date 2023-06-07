<?php

namespace App\Rules;

use App\Models\product;
use Illuminate\Contracts\Validation\InvokableRule;

class ProductExists implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $product = product::find($value);
        if($product==null){
            $fail("product does not exist");
        }
    }
}
