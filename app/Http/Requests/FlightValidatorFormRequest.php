<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FlightValidatorFormRequest extends FormRequest
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
            'airplane_id' => 'required|exists:airplanes,id',
            'airport_origin_id' => 'required|exists:airports,id',
            'airport_destination_id' => 'required|exists:airports,id',
            'date' => 'required|date|after:today',
            'time_duration' => 'required',
            'hour_output' => 'required',
            'arrival_time' => 'required',
            'old_price' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'total_plots' => 'required|integer|min:1|max:12',
            'is_promotion' => 'boolean',
            'image' => 'image',
            'qty_stops' => 'integer|min:0|max:9',
            'description' => 'min:5|max:200',
        ];
    }
}
