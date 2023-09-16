<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Airplane;
use App\Models\Airport;
use App\Models\Brand;
use App\Models\City;
use App\Models\Flight;
use App\Models\Reserve;
use App\Models\State;
use App\Models\User;

class PanelController extends Controller
{
    public function index()
    {
        $totalBrands = Brand::count();
        $totalAirplanes = Airplane::count();
        $totalStates = State::count();
        $totalCities = City::count();
        $totalFlights = Flight::count();
        $totalAirports = Airport::count();
        $totalUsers = User::count();
        $totalReserves = Reserve::count();

        return view('panel.home.index', compact('totalBrands', 'totalAirplanes', 'totalAirplanes',
            'totalStates', 'totalCities', 'totalFlights', 'totalAirports', 'totalUsers', 'totalReserves'));
    }
}
