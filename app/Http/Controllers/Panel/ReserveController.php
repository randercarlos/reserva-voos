<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReserveValidatorFormRequest;
use App\Models\Flight;
use App\Models\Reserve;
use App\Models\User;
use App\Reports\ReserveReport;
use Illuminate\Http\Request;

class ReserveController extends Controller
{
    private $reserve;

    public function __construct(Reserve $reserve)
    {
        $this->reserve = $reserve;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Reservas de Passagens Aéreas';

        $reserves = $this->reserve->with(['user', 'flight.origin'])->paginate(Reserve::TOTAL_PAGE);
        $status = $this->reserve->getStatus();

        return view('panel.reserve.index', compact('title', 'reserves', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Nova Reserva';

        $users = User::pluck('name', 'id');
        $flights = Flight::pluck('id', 'id');
        $status = $this->reserve->getStatus();

        return view('panel.reserve.form', compact('title', 'users', 'flights', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReserveValidatorFormRequest $request)
    {
        if ($this->reserve->create($request->all())) {
            return redirect()->route('reserves.index')->with('success', 'Reserva feita com sucesso!');
        }

        return redirect()->back()->with('error', 'Falha ao Reserva!')->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reserve = $this->reserve->with(['user', 'flight'])->find($id);
        if (! $reserve) {
            return redirect()->back()->withInput();
        }

        $title = 'Editar Reserva do Usuário: '.$reserve->user->name;
        $users = User::pluck('name', 'id');
        $flights = Flight::pluck('id');
        $status = $this->reserve->getStatus();

        return view('panel.reserve.form', compact('title', 'users', 'flights', 'status', 'reserve'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReserveValidatorFormRequest $request, $id)
    {
        //dd($request->all());
        $reserve = $this->reserve->find($id);
        if (! $reserve) {
            return redirect()->back();
        }

        if ($reserve->update($request->all())) {
            return redirect()->route('reserves.index')->with('success', 'Status da reserva atualizado com sucesso!');
        }

        return redirect()->back()->with('error', 'Falha ao atualizar Reserva!')->withInput();
    }

    public function search(Request $request)
    {
        $reserves = $this->reserve->search($request);

        $title = 'Resultados para a pesquisa: '.$request->q;
        $dataForm = $request->except('_token');
        $status = $this->reserve->getStatus();

        return view('panel.reserve.index', compact('reserves', 'title', 'dataForm', 'status'));
    }

    public function report()
    {
        $data = Reserve::with(['user', 'flight.airplane'])->orderBy('id', 'asc')->get()->toArray();

        //dd($data);

        $pdf = new ReserveReport('L', 'mm', 'A4');
        $pdf->generateReport($pdf, 'Relatórios de Reservas', $data);
    }
}
