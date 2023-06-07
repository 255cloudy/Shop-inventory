<?php

namespace App\Rules;

use App\Models\categories;
use Illuminate\Contracts\Validation\InvokableRule;

class CategoryExists implements InvokableRule
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
        if(categories::find($value)==null){
            $fail("the category does not exist");
        }
    }
}
