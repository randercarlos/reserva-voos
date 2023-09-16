<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AirplaneValidatorFormRequest extends FormRequest
{
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:30|unique:airplanes',
            'qty_passengers' => 'required|integer|min:1|max:999',
            'class' => 'required|in:economic,executive,first_class',
            'brand_id' => 'required|exists:brands,id',
        ];
    }
}
