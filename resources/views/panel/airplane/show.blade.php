@extends('panel.template.app')

@section('content')

    <div class="bred">
        <a href="{{ route('panel.index') }}" class="bred">Home ></a> 
        <a href="{{ route('airplanes.index') }}" class="bred">Aviões ></a>
        <a href="#" class="bred">Detalhe</a>
    </div>
        
    <div class="title-pg">
    	<h1 class="title-pg">Detalhes do Avião</h1>
    </div>


    <div class="content-din">
        
        
        <table class="table table-striped" style="width: 40%">
            <tr>
                <th>Nome</th>
                <td>{{ $airplane->name }}</td>
            </tr>
            <tr>
                <th>Marca</th>
                <td>{{ $airplane->brand->name }}</td>
            </tr>
            <tr>
                <th>Capacidade de passageiros</th>
                <td>{{ $airplane->qty_passengers }}</td>
            </tr>
            <tr>
                <th>Classe</th>
                <td>{{ $airplane->class }}</td>
            </tr>
        </table>
        
        
        {!! Form::open(['route' => ['airplanes.destroy', $airplane->id], 'class' => 'form form-search form-ds', 
            'method' => 'DELETE']) !!}

            <div class="form-group">
                <button class="btn btn-danger">Deletar o avião {{ $airplane->name }} </button>
            </div>
            
        {!! Form::close() !!}

    </div><!--Content Dinâmico-->
    
@endsection