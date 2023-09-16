@extends('panel.template.app')

@section('content')

    <div class="bred">
        <a href="{{ route('panel.index') }}" class="bred">Home ></a> 
        <a href="{{ route('airports.index') }}" class="bred">Aeroportos ></a>
        <a href="#" class="bred">Detalhe</a>
    </div>
        
    <div class="title-pg">
    	<h1 class="title-pg">Detalhes: <b>{{ $airport->name }}</b></h1>
    </div>


    <div class="content-din">
        
        <table class="table table-striped" style="width: 40%">
            <tr>
                <th>Nome</th>
                <td>{{  $airport->name }}</td>
            </tr>
            <tr>
                <th>Cidade</th>
                <td>{{ $airport->city->name }}</td>
            </tr>
            <tr>
                <th>Latitude</th>
                <td>{{ $airport->latitude or '- '}}</td>
            </tr>
            <tr>
                <th>Longitude</th>
                <td>{{ $airport->longitude or '- ' }}</td>
            </tr>
            <tr>
                <th>Endereço</th>
                <td>{{ $airport->address or '- ' }}</td>
            </tr>
            <tr>
                <th>Número</th>
                <td>{{ $airport->number or '- ' }}</td>
            </tr>
            <tr>
                <th>Código Postal</th>
                <td>{{ $airport->zip_code or '- ' }}</td>
            </tr>
            <tr>
                <th>Complemento</th>
                <td>{{ $airport->complement or '- ' }}</td>
            </tr>
        </table>
        
        {!! Form::open(['route' => ['airports.destroy', $airport->id], 'class' => 'form form-search form-ds', 
            'method' => 'DELETE']) !!}

            <div class="form-group">
                <button class="btn btn-danger">Deletar o Aeroporto: <b>{{ $airport->name }}</b> </button>
            </div>
            
        {!! Form::close() !!}

    </div><!--Content Dinâmico-->
    
@endsection