<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\FlightValidatorFormRequest;
use App\Models\Airplane;
use App\Models\Airport;
use App\Models\Flight;
use App\Reports\FlightReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FlightController extends Controller
{
    private $flight;

    public function __construct(Flight $flight)
    {
        $this->flight = $flight;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Voos';
        $flights = $this->flight->getItems();
        $airports = Airport::pluck('name', 'id');

        return view('panel.flight.index', compact('flights', 'title', 'airports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Cadastrar Voo';
        $airplanes = Airplane::pluck('name', 'id');
        $airports = Airport::pluck('name', 'id');

        return view('panel.flight.form', compact('title', 'airplanes', 'airports'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FlightValidatorFormRequest $request)
    {
        $newName = null;

        // faz upload da imagem e salva dentro da pasta storage/public/flights
        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            $newName = strval(uniqid(date('HisYmd'))).'.'.$request->image->extension();

            /* flights é a pasta onde será feito o upload junto com o caminho especificados na variável
               root do arquivo filesystems.php em /config
            */
            if (! $request->image->storeAs('flights', $newName)) {
                return redirect()->back()->with('error', 'Falha ao fazer upload da imagem!')->withInput();
            }

            // Deleta a imagem antiga depois de fazer o upload da nova
            $path_file = public_path().'/uploads/flights/'.$request->image;
            if (File::exists($path_file)) {
                File::delete($path_file);
            }
        }

        if ($this->flight->newFlight($request, $newName)) {
            return redirect()->route('flights.index')->with('success', 'Voo cadastrado com sucesso!');
        }

        return redirect()->back()->with('error', 'Falha ao cadastrar Voo');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $flight = $this->flight->with(['origin', 'destination'])->find($id);
        if (! $flight) {
            return redirect()->back();
        }

        $title = 'Detalhes do Voo: '.$flight->name;

        return view('panel.flight.show', compact('title', 'flight'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $flight = $this->flight->find($id);
        if (! $flight) {
            return redirect()->back();
        }

        $title = 'Editar Voo: '.$flight->name;
        $airplanes = Airplane::pluck('name', 'id');
        $airports = Airport::pluck('name', 'id');

        return view('panel.flight.form', compact('title', 'airplanes', 'airports', 'flight'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FlightValidatorFormRequest $request, $id)
    {
        $newName = null;
        $dataForm = $request->all();

        $flight = $this->flight->find($id);
        if (! $flight) {
            return redirect()->back();
        }

        // faz upload da imagem e salva dentro da pasta storage/public/flights
        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            $newName = strval(uniqid(date('HisYmd'))).'.'.$request->image->extension();

            /* flights é a pasta onde será feito o upload junto com o caminho especificados na variável
             root do arquivo filesystems.php em /config
             */
            if (! $request->image->storeAs('flights', $newName)) {
                return redirect()->back()->with('error', 'Falha ao fazer upload da imagem!')->withInput();
            }

            // Deleta a imagem antiga depois de fazer o upload da nova
            $path_file = public_path().'/uploads/flights/'.$flight->image;
            if (File::exists($path_file)) {
                File::delete($path_file);
            }

            $dataForm['image'] = $newName;
        }

        if ($flight->update($dataForm)) {
            return redirect()->route('flights.index')->with('success', 'Voo atualizado com sucesso!');
        }

        return redirect()->back()->with('error', 'Falha ao atualizar Voo')->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $flight = $this->flight->find($id);
        if (! $flight) {
            return redirect()->back()->with('error', 'Voo não encontrado!');
        }

        // Deleta a imagem do usuário se existir
        $path_file = public_path().'/uploads/flights/'.$flight->image;
        if (File::exists($path_file)) {
            File::delete($path_file);
        }

        if ($flight->delete()) {
            return redirect()->route('flights.index')->with('success', 'Voo excluído com sucesso!');
        }

        return redirect()->back()->with('error', 'Falha ao excluir Voo')->withInput();
    }

    public function search(Request $request)
    {
        $flights = $this->flight->search($request);
        $airports = Airport::pluck('name', 'id');

        $title = 'Resultado de voos pesquisados';

        return view('panel.flight.index', compact('title', 'flights', 'airports'));
    }

    public function report()
    {
        $data = Flight::with(['origin', 'destination', 'airplane'])->orderBy('id', 'asc')->get()->toArray();

        $pdf = new FlightReport('L', 'mm', 'A4');
        $pdf->generateReport($pdf, 'Relatórios de Voos', $data);
    }
}
