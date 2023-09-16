<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    private $state;

    public function __construct(State $state)
    {
        $this->state = $state;
    }

    public function index()
    {
        $states = $this->state->get();

        $title = 'Listagem de Estados brasileiros';

        return view('panel.state.index', compact('states', 'title'));
    }

    public function search(Request $request)
    {
        $dataForm = $request->all();
        $q = $request->q;

        $states = $this->state->search($q);
        $title = 'Resultados de estado: '.$q;

        return view('panel.state.index', compact('states', 'title', 'dataForm'));
    }
}
