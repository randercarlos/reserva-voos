<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\AirplaneValidatorFormRequest;
use App\Models\Airplane;
use App\Models\Brand;
use App\Reports\AirplaneReport;
use Illuminate\Http\Request;

class AirplaneController extends Controller
{
    private $airplane;

    public function __construct(Airplane $airplane)
    {
        $this->airplane = $airplane;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Listagem de Aviões';

        // with('brand') -> traz o relacionamento em apenas uma consulta. Evita fazer consulta dentro de loop
        // para trazer o relacionamento
        $airplanes = $this->airplane->with('brand')->paginate(Airplane::TOTAL_PAGE);

        return view('panel.airplane.index', compact('title', 'airplanes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Cadastrar avião';
        $classes = $this->airplane->classes();
        $brands = Brand::pluck('name', 'id');

        return view('panel.airplane.form', compact('title', 'classes', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AirplaneValidatorFormRequest $request)
    {
        if ($this->airplane->create($request->all())) {
            return redirect()->route('airplanes.index')->with('success', 'Avião '.$request->name
                .' cadastrado com sucesso!');
        }

        return redirect()->back()->with('error', 'Falha ao cadastrar Avião!')->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $airplane = $this->airplane->with('brand')->find($id);
        if (! $airplane) {
            return redirect()->back();
        }

        $title = 'Detalhes do Avião: '.$airplane->name;

        return view('panel.airplane.show', compact('title', 'airplane'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $airplane = $this->airplane->find($id);
        if (! $airplane) {
            return redirect()->back();
        }

        $title = 'Editar Avião: '.$airplane->name;
        $classes = $this->airplane->classes();
        $brands = Brand::pluck('name', 'id');

        return view('panel.airplane.form', compact('title', 'airplane', 'classes', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AirplaneValidatorFormRequest $request, $id)
    {
        $airplane = $this->airplane->find($id);
        if (! $airplane) {
            return redirect()->back();
        }

        if ($this->airplane->update($request->all())) {
            return redirect()->route('airplanes.index')->with('success', 'Avião '.$request->name
                .' atualizado com sucesso!');
        }

        return redirect()->back()->with('error', 'Falha ao cadastrar Avião!')->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $airplane = $this->airplane->find($id);
        $airplane_name = $airplane->name;

        if (! $airplane) {
            return redirect()->back();
        }

        if ($airplane->delete()) {
            return redirect()->route('airplanes.index')->with('success', 'Avião '.$airplane_name
                .' excluído com sucesso!');
        }

        return redirect()->back()->with('error', 'Falha ao cadastrar Avião!')->withInput();
    }

    public function search(Request $request)
    {
        // recuperar os dados do form para que sejam reenviados para view para preservá-lo o filtro
        $dataForm = $request->except('_token');
        $airplanes = $this->airplane->search($request->q);
        $title = 'Aviões, filtro para: '.$request->q;

        return view('panel.airplane.index', compact('title', 'airplanes', 'dataForm'));

    }

    public function report()
    {
        $data = Airplane::with('brand')->orderBy('name', 'asc')->get()->toArray();

        $pdf = new AirplaneReport('L', 'mm', 'A4');
        $pdf->generateReport($pdf, 'Relatórios de Aviões', $data);
    }
}
