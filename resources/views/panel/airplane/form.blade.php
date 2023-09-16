@extends('panel.template.app')

@section('content')

    <div class="bred">
        <a href="{{ route('panel.index') }}" class="bred">Home ></a> 
        <a href="{{ route('airplanes.index') }}" class="bred">Aviões ></a>
        <a href="#" class="bred">{{ isset($airplane) ? 'Editar' : 'Cadastrar' }}</a>
    </div>

    <div class="title-pg">
        <h1 class="title-pg">{{ isset($airplane) ? "Editar Avião: {$airplane->id} " : 'Cadastrar Avião' }}</h1>
    </div>

    <div class="content-din">
    
        @include('panel.includes.errors')
            
            
        @if (isset($airplane))
            {!! Form::model($airplane,['route' => ['airplanes.update', $airplane->id], 
                'class' => 'form form-search form-ds', 'method' => 'PUT']) !!}
        @else
            {!! Form::open(['route' => 'airplanes.store', 'class' => 'form form-search form-ds']) !!}
        @endif
        
            {!! csrf_field() !!}

            <div class="form-group">
                <label for="name">Nome:</label>
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nome:']) !!}
            </div>
            
            <div class="form-group">
                <label for="qty_passengers">Capacidade de passageiros:</label>
                {!! Form::number('qty_passengers', null, ['class' => 'form-control', 'placeholder' => 'Capacidade:']) !!}
            </div>
            
            <div class="form-group">
                <label for="class">Classe:</label>
                {!! Form::select('class', $classes, null, ['class' => 'form-control']) !!}
            </div>
            
            <div class="form-group">
                <label for="brand_id">Marca:</label>
                {!! Form::select('brand_id', $brands, null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                <button class="btn btn-search">Salvar</button>
            </div>
         {!! Form::close() !!}

    </div><!--Content Dinâmico-->

@endsection