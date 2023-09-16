<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    const TOTAL_PAGE = 10;

    public function search($q)
    {
        return $this->where('name', 'LIKE', '%'.$q.'%')
            ->orWhere('initials', $q)
            ->get();
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function searchCities($q)
    {
        return $this->cities()->where('name', 'LIKE', '%'.$q.'%')->paginate(self::TOTAL_PAGE);
    }
}
