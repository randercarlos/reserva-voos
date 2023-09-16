<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AirportValidatorFormRequest extends FormRequest
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
            'name' => 'required|min:5|max:100|unique:airports',
            'city_id' => 'required|exists:cities,id',
            'latitude' => 'max:10',
            'longitude' => 'max:10',
            'address' => 'max:100',
            'number' => 'max:7',
            'zip_code' => 'max:7',
            'complement' => 'max:100',
        ];
    }
}
