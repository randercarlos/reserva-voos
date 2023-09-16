<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    const TOTAL_PAGE = 10;

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function airports()
    {
        return $this->hasMany(Airport::class);
    }

    public function getCityStateAttribute($value)
    {
        return $this->name.' - '.$this->state->initials;
    }
}
