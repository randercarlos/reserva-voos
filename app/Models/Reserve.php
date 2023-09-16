<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    const TOTAL_PAGE = 20;

    protected $fillable = ['user_id', 'flight_id', 'date_reserved', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

    public function getStatus($op = null)
    {
        $statusAvailable = [
            'reserved' => 'Reservado',
            'canceled' => 'Cancelado',
            'paid' => 'Pago',
            'concluded' => 'Concluído',
        ];

        if (! is_null($op)) {
            return $statusAvailable[$op];
        }

        return $statusAvailable;
    }

    public function search($request)
    {
        $reserves = $this->join('users', 'users.id', '=', 'reserves.user_id')
            ->join('flights', 'flights.id', '=', 'reserves.flight_id')
            ->select('reserves.*',
                'users.name as user_name',
                'users.email as user_email',
                'users.id as user_id',
                'flights.id as flight_id',
                'flights.date as flight_date')
            ->where(function ($query) use ($request) {

                if ($request->user) {
                    $query->where('users.name', 'LIKE', '%'.$request->user.'%');
                    $query->orWhere('users.email', 'LIKE', '%'.$request->user.'%');
                }

                if ($request->date) {
                    $query->where('reserves.date_reserved', $request->date);
                }

                if ($request->reserve) {
                    $query->where('reserves.id', $request->reserve);
                }

                if ($request->status) {
                    $query->where('reserves.status', $request->status);
                }

            })
            ->with(['user', 'flight'])
            ->paginate(self::TOTAL_PAGE);

        return $reserves;
    }

    public function newReserve($id_flight)
    {
        // seta os dados manualmente para evitar manipulações no formulário de reserva
        $this->user_id = auth()->user()->id;
        $this->flight_id = $id_flight;
        $this->date_reserved = date('Y-m-d');
        $this->status = 'reserved';

        return $this->save();
    }
}
