<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Airplane extends Model
{
    protected $fillable = ['name', 'brand_id', 'qty_passengers', 'class'];

    const TOTAL_PAGE = 10;

    public function classes()
    {
        return [
            '' => 'Selecione uma classe...',
            'economic' => 'Econômica',
            'executive' => 'Executiva',
            'first_class' => '1º Classe',
        ];
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function search($q)
    {
        return $this->where('name', 'LIKE', '%'.$q.'%')
            ->orWhere('qty_passengers', $q)
            ->orWhere('class', $q)
            ->paginate(self::TOTAL_PAGE);
    }

    public static function getClass($class)
    {
        $classes = [
            'economic' => 'Econômica',
            'executive' => 'Executiva',
            'first_class' => '1º Classe',
        ];

        return $classes[$class];
    }
}
