<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = ['name'];

    const TOTAL_PAGE = 10;

    public function search($q)
    {
        return $this->where('name', 'LIKE', '%'.$q.'%')->paginate(self::TOTAL_PAGE);
    }

    public function airplanes()
    {
        return $this->hasMany(Airplane::class);
    }
}
