@extends('panel.template.app')

@section('content')

    <div class="bred">
        <a href="{{ route('panel.index') }}" class="bred">Home  ></a> 
        <a href="{{ route('brands.index') }}" class="bred">Marcas ></a>
        <a href="{{ route('brands.airplanes', $brand->id) }}" class="bred">Aviões</a>
    </div>
        
    <div class="title-pg">
        <h1 class="title-pg">Aviões da Marca: <b>{{ $brand->name }}</b></h1>
    </div>


    <div class="content-din bg-white">

        
        <table class="table table-striped">
            <tr>
                <th>Nome</th>
                <th>Classe</th>
                <th>Capacidade</th>
                <th width="130" style="text-align: center;">Ações</th>
            </tr>

            @forelse($airplanes as $airplane)
                <tr>
                    <td> {{ $airplane->name }}</td>
                    <td> {{ $airplane->class }}</td>
                    <td> {{ $airplane->qty_passengers }}</td>
                    <td>
                        <a href="{{ route('airplanes.edit', $airplane->id) }}" class="edit">Editar</a>
                        <a href="{{ route('airplanes.show', $airplane->id) }}" class="delete">Ver</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Nenhum registro encontrado!</td>
                </tr>
            @endforelse
        </table>


    </div><!--Content Dinâmico-->

    
@endsection