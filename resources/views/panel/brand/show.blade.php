@extends('panel.template.app')

@section('content')

    <div class="bred">
        <a href="{{ route('panel.index') }}" class="bred">Home ></a> 
        <a href="{{ route('brands.index') }}" class="bred">Marcas ></a>
        <a href="#" class="bred">Detalhe</a>
    </div>
        
    <div class="title-pg">
    	<h1 class="title-pg">Detalhes da Marca</h1>
    </div>


    <div class="content-din">
        
        <table class="table" style="width: 40%">
            <tr>
                <th>Nome</th>
                <td>{{ $brand->name }}</td>
            </tr>
        </table>
        
        {!! Form::open(['route' => ['brands.destroy', $brand->id], 'class' => 'form form-search form-ds', 
            'method' => 'DELETE']) !!}

            <div class="form-group">
                <button class="btn btn-danger">Deletar a marca {{ $brand->name }} </button>
            </div>
            
        {!! Form::close() !!}

    </div><!--Content Dinâmico-->
    
@endsection