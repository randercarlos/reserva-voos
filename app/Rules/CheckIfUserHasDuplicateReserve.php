<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Request;

class CheckIfUserHasDuplicateReserve implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = auth()->user();
        $id_flight = intval($value);

        // se o usuário já possuir uma reserva para esse voo, a validação retorna false.
        // Caso contrário, true
        foreach ($user->reserves as $reserve) {
            if ($reserve->flight->id == $id_flight) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $id_flight = Request::input('flight_id');

        return "Você já possui uma reserva para o Voo #{$id_flight}!";
    }
}
