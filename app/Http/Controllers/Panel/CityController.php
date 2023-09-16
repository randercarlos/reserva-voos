<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index($initials)
    {
        $state = State::where('initials', $initials)->with('cities')->get()->first();
        if (! $state) {
            return redirect()->back();
        }

        $cities = $state->cities()->paginate(City::TOTAL_PAGE);
        $title = 'Cidades do Estado '.$state->name;

        return view('panel.city.index', compact('cities', 'title', 'state'));
    }

    public function search(Request $request, $initials)
    {
        $state = State::where('initials', $initials)->get()->first();
        if (! $state) {
            return redirect()->back();
        }

        $dataForm = $request->all();
        $q = $request->q;

        $cities = $state->searchCities($q);
        $title = 'Filtro <b>'.$q.'</b> para cidades do Estado: <b>'.$state->name.'</b>';

        return view('panel.city.index', compact('cities', 'title', 'state', 'dataForm'));
    }
}
