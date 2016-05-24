<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use FBA\Models\Basket;

class UpdateBasketRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $basketID = $this->id;
        $basket = Basket::find($basketID);
        if ($basket) {
            return true;
        } else false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:255',
            'max_capacity' => 'required|between:0.1,1000000.9999'
        ];
    }
}
