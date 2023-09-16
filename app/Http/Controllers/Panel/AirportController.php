<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\AirportValidatorFormRequest;
use App\Models\Airport;
use App\Models\City;
use App\Reports\AirportReport;
use Illuminate\Support\Facades\Cache;

class AirportController extends Controller
{
    private $airport;

    private $city;

    public function __construct(Airport $airport, City $city)
    {
        $this->airport = $airport;
        $this->city = $city;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Airport';

        $airports = $this->airport->with('city.state')->paginate(Airport::TOTAL_PAGE);
        $cities = $this->airport->getCitiesWhereExistsAirports();

        return view('panel.airport.index', compact('airports', 'cities', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Cadastrar Aeroporto';
        $cities = Cache::rememberForever('cities', function () {
            return City::pluck('name', 'id');
        });

        return view('panel.airport.form', compact('title', 'cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AirportValidatorFormRequest $request)
    {
        if ($this->airport->create($request->all())) {
            return redirect()->route('airports.index')->with('success', 'Aeroporto cadastrado com sucesso');
        }

        return redirect()->back()->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $airport = $this->airport->with('city')->find($id);
        if (! $airport) {
            return redirect()->back();
        }

        $title = 'Detalhes do Aeroporto:'.$airport->name;

        return view('panel.airport.show', compact('title', 'airport'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $airport = $this->airport->with('city')->find($id);
        if (! $airport) {
            return redirect()->back();
        }

        $title = 'Editar Aeroporto:'.$airport->name;
        $cities = Cache::rememberForever('cities', function () {
            return City::pluck('name', 'id');
        });

        return view('panel.airport.form', compact('title', 'airport', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AirportValidatorFormRequest $request, $id)
    {
        $airport = $this->airport->with('city')->find($id);
        if (! $airport) {
            return redirect()->back();
        }

        if ($airport->update($request->all())) {
            return redirect()->route('airports.index')->with('success', 'Aeroporto atualizado com sucesso!');
        }

        return redirect()->back()->with('error', 'Falha ao atualizar Aeroporto!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $airport = $this->airport->with('city')->find($id);
        if (! $airport) {
            return redirect()->back();
        }

        if ($airport->delete($id)) {
            return redirect()->route('airports.index')
                ->with('success', "O Aeroporto {$airport->name} foi excluído com sucesso!");
        }

        return redirect()->back()->with('error', "Falha ao deletar o aeroporto {$brand->name}!");
    }

    public function city($id_city)
    {
        $title = 'Airport';

        $city = $this->city->find($id_city);
        if (! $city) {
            return redirect()->back();
        }

        $airports = $this->airport->airportsByCity($id_city);
        $cities = $this->airport->getCitiesWhereExistsAirports();

        return view('panel.airport.index', compact('airports', 'title', 'city', 'cities'));
    }

    public function search(AirportValidatorFormRequest $request)
    {
        // recuperar os dados do form para que sejam reenviados para view para preservá-lo o filtro
        $dataForm = $request->except(['id', '_token']);
        $airports = $this->airport->search($request);

        $cities = $this->airport->citiesWhereExistsAirports();

        $title = 'Resultado de Aeroportos pesquisados por: '.$request->q;

        return view('panel.airport.index', compact('title', 'airports', 'cities', 'dataForm'));
    }

    public function report()
    {
        $data = Airport::with('city.state')->orderBy('id', 'asc')->get()->toArray();

        $pdf = new AirportReport('L', 'mm', 'A4');
        $pdf->generateReport($pdf, 'Relatórios de Aeroportos', $data);
    }
}
