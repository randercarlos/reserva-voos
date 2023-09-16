<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandValidatorFormRequest;
use App\Models\Brand;
use App\Reports\BrandReport;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    private $brand;

    public function __construct(Brand $brand)
    {
        $this->brand = $brand;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Marcas de Aviões';

        $brands = $this->brand->paginate(Brand::TOTAL_PAGE);

        return view('panel.brand.index', compact('title', 'brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Marcas de Aviões';

        return view('panel.brand.form', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandValidatorFormRequest $request)
    {
        if ($this->brand->create($request->all())) {
            return redirect()->route('brands.index')->with('success', 'Cadastro realizado com sucesso!');
        }

        return redirect()->back()->with('error', 'Falha ao cadastrar');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $brand = $this->brand->find($id);
        if (! $brand) {
            return redirect()->back();
        }

        $title = 'Detalhes da Marca:'.$brand->name;

        return view('panel.brand.show', compact('title', 'brand'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = $this->brand->find($id);
        if (! $brand) {
            return redirect()->back();
        }

        $title = 'Editar Marca:'.$brand->name;

        return view('panel.brand.form', compact('title', 'brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BrandValidatorFormRequest $request, $id)
    {
        $brand = $this->brand->find($id);
        if (! $brand) {
            return redirect()->back();
        }

        if ($brand->update($request->all())) {
            return redirect()->route('brands.index')->with('success', 'Registro atualizado com sucesso!');
        }

        return redirect()->back()->with('error', 'Falha ao atualizar!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = $this->brand->find($id);
        if (! $brand) {
            return redirect()->back();
        }

        if ($brand->delete($id)) {
            return redirect()->route('brands.index')
                ->with('success', "A marca {$brand->name} foi deletada com sucesso!");
        }

        return redirect()->back()->with('error', "Falha ao deletar a marca {$brand->name}!");
    }

    public function search(Request $request)
    {
        // recuperar os dados do form para que sejam reenviados para view para preservá-lo o filtro
        $dataForm = $request->except('_token');
        $brands = $this->brand->search($request->q);
        $title = 'Brands, filtro para: '.$request->q;

        return view('panel.brand.index', compact('title', 'brands', 'dataForm'));
    }

    public function airplanes($id)
    {
        $brand = $this->brand->find($id);
        if (! $brand) {
            return redirect()->back();
        }

        $title = 'Aviões da marca: '.$brand->name;
        $airplanes = $brand->airplanes()->get();

        return view('panel.brand.airplanes', compact('title', 'airplanes', 'brand'));
    }

    public function report()
    {
        $data = Brand::orderBy('name', 'asc')->get()->toArray();

        $pdf = new BrandReport('L', 'mm', 'A4');
        $pdf->generateReport($pdf, 'Relatórios de Marcas', $data);
    }
}
