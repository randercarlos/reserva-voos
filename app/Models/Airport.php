<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Airport extends Model
{
    const TOTAL_PAGE = 10;

    protected $guarded = ['id', '_token'];

    public function airportsByCity($id_city)
    {
        return $this->where('city_id', $id_city)->paginate(self::TOTAL_PAGE);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function search(Request $request)
    {
        $airports = $this->where(function ($query) use ($request) {
            if ($request->name) {
                $query->where('name', 'LIKE', '%'.$request->name.'%');
            }

            if ($request->city) {
                $query->where('city_id', $request->city);
            }

        })->with('city')->paginate(self::TOTAL_PAGE);

        return $airports;
    }

    public function getCitiesWhereExistsAirports()
    {
        return $this->join('cities', 'cities.id', '=', 'airports.city_id')
            ->select('cities.id', 'cities.name')
            ->pluck('name', 'id');
    }

    public function getAirportsWithCities()
    {
        $airports = $this->with('city')->get();

        $results = [];
        foreach ($airports as $airport) {
            $results[$airport->id] = $airport->name.' / '.$airport->city->name;
        }

        return collect($results);
    }
}
