<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Flight extends Model
{
    const TOTAL_PAGE = 10;

    protected $casts = [
        'is_promotion' => 'boolean',
    ];

    protected $fillable = [
        'airplane_id',
        'airport_origin_id',
        'airport_destination_id',
        'date',
        'time_duration',
        'hour_output',
        'arrival_time',
        'old_price',
        'price',
        'total_plots',
        'is_promotion',
        'image',
        'qty_stops',
        'description',
    ];

    public function newFlight(Request $request, $nameFile = '')
    {
        $dataForm = $request->all();
        $dataForm['image'] = $nameFile;

        return $this->create($dataForm);
    }

    public function getItems()
    {
        return $this->with(['origin', 'destination'])->paginate(self::TOTAL_PAGE);
    }

    public function origin()
    {
        return $this->belongsTo(Airport::class, 'airport_origin_id');
    }

    public function destination()
    {
        return $this->belongsTo(Airport::class, 'airport_destination_id');
    }

    public function airplane()
    {
        return $this->belongsTo(Airplane::class, 'airplane_id');
    }

    public function reserves()
    {
        return $this->hasMany(Reserve::class)->where('reserves.status', '<>', 'canceled');
    }

    // Acessors do laravel
    public function getDepartureDateAttribute($value)
    {
        return date('d/m/Y', strtotime($this->attributes['date']));
    }

    public function search($request)
    {
        $flights = $this->where(function ($query) use ($request) {

            if ($request->code) {
                $query->where('id', $request->code);
            }

            if ($request->date) {

                if (isset($request->filter_date) && $request->filter_date == 'igual') {
                    $query->where('date', '=', $request->date);
                } else {
                    $query->Where('date', '>=', $request->date);
                }
            }

            if ($request->hour_output) {
                $query->where('hour_output', $request->hour_output);
            }

            if ($request->total_stops) {
                $query->where('qty_stops', intval($request->total_stops));
            }

            if ($request->origin) {
                $query->where('airport_origin_id', intval($request->origin));
            }

            if ($request->destination) {
                $query->where('airport_destination_id', intval($request->destination));
            }
        })->with(['origin', 'destination'])->paginate(self::TOTAL_PAGE);

        return $flights;
    }

    public function promotions()
    {
//        dd($this->where('is_promotion', true)->where('date', '>=', now())->with(['origin.city.state', 'destination.city.state'])->get()->toArray());
        return $this->where('is_promotion', true)
            ->where('date', '>=', now())
            ->with(['origin.city.state', 'destination.city.state'])->get();
    }
}
