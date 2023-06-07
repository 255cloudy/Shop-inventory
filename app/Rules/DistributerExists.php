<?php

namespace App\Rules;

use App\Models\distributer;
use Illuminate\Contracts\Validation\InvokableRule;

class DistributerExists implements InvokableRule
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
        if(distributer::find($value) != null){
            $fail("distributer does not exist");
        }
    }
}
