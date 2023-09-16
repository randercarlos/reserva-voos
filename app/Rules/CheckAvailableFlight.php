<?php

namespace App\Rules;

use App\Models\Flight;
use Illuminate\Contracts\Validation\Rule;

class CheckAvailableFlight implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {

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
        $flight = Flight::with(['airplane', 'reserves'])->find(intval($value));
        $airplane = $flight->airplane;
        $capacityPassengers = $airplane->qty_passengers;
        $qtyReserves = $flight->reserves->count();

        // se a quantidade de reservas feitas para um determinado voo for menor que a capacidade total de passageiros
        // de um determinado avião, retorna true, caso contrário, retorna false
        return $qtyReserves < $capacityPassengers;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A quantidade reservas superou a quantidade de passageiros permitidos!';
    }
}
