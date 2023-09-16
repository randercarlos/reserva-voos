<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    const TOTAL_PAGE = 10;

    protected $fillable = ['name', 'email', 'password', 'image', 'is_admin'];

    protected $hidden = ['password', 'remember_token'];

    public function search(Request $request)
    {
        $q = $request->q;

        return $this->where('name', 'LIKE', '%'.$q.'%')
            ->orWhere('email', 'LIKE', '%'.$q.'%')
            ->paginate(self::TOTAL_PAGE);
    }

    public function reserves()
    {
        return $this->hasMany(Reserve::class);
    }

    // atribui bcrypt ao password
    public function setPasswordAttribute($password)
    {
        if (! empty($password)) {
            $this->attributes['password'] = bcrypt($password);
        }
    }
}
