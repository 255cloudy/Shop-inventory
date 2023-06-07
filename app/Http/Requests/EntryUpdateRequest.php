<?php

namespace App\Http\Requests;

use App\Rules\ProductExists;
use Illuminate\Foundation\Http\FormRequest;

class EntryUpdateRequest extends FormRequest
{
    protected $errorBag = "update";
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "product_id" => ["required", new ProductExists()],
            "price" => "required",
            "qty" => "required",
        ];
    }
}
