<?php

namespace App\Http\Requests;

use App\Models\Reserve;
use App\Rules\CheckAvailableFlight;
use App\Rules\CheckIfUserHasDuplicateReserve;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReserveValidatorFormRequest extends FormRequest
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
        $reserve = new Reserve();

        return [
            'user_id' => 'required|exists:users,id',
            'flight_id' => [
                'required',
                'exists:flights,id',
                new CheckAvailableFlight(),
                new CheckIfUserHasDuplicateReserve(),
            ],
            'date_reserved' => 'required|date',
            'status' => [
                'required', Rule::in(array_keys($reserve->getStatus())),
            ],
        ];
    }
}
