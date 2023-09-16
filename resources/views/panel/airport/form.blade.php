@extends('panel.template.app')

@section('content')

    <div class="bred">
        <a href="{{ route('panel.index') }}" class="bred">Home ></a> 
        <a href="{{ route('airports.index') }}" class="bred">Aeroportos ></a>
        <a href="#" class="bred">{{ isset($airport) ? 'Editar' : 'Cadastrar' }}</a>
    </div>

    <div class="title-pg">
        <h1 class="title-pg">
            {!! isset($airport) ? "Editar Aeroporto: <b>{$airport->name}</b>" : 'Cadastrar Aeroporto' !!}
        </h1>
    </div>

    <div class="content-din">
    
        @include('panel.includes.errors')
            
            
        @if (isset($airport))
            {!! Form::model($airport,['route' => ['airports.update', $airport->id], 
                'class' => 'form form-search form-ds', 'method' => 'PUT']) !!}
            {!! csrf_field() !!}
        @else
            {!! Form::open(['route' => 'airports.store', 'class' => 'form form-search form-ds']) !!}
        @endif
            {!! csrf_field() !!}
    
            <div class="form-group">
                <label for="name">Nome:</label>
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nome:']) !!}
            </div>
            
            <div class="form-group">
                <label for="name">Cidade:</label>
                {!! Form::select('city_id', $cities, null, ['class' => 'form-control', 
                    'placeholder' => 'Selecione a cidade...']) !!}
            </div>
            
            <div class="form-group">
                <label for="latitude">Latitude:</label>
                {!! Form::text('latitude', null, ['class' => 'form-control', 'placeholder' => 'Latitude:']) !!}
            </div>
            
            <div class="form-group">
                <label for="longitude">Longitude:</label>
                {!! Form::text('longitude', null, ['class' => 'form-control', 'placeholder' => 'Longitude:']) !!}
            </div>
            
            <div class="form-group">
                <label for="address">Endereço:</label>
                {!! Form::text('address', null, ['class' => 'form-control', 'placeholder' => 'Endereço:']) !!}
            </div>
            
            <div class="form-group">
                <label for="number">Número:</label>
                {!! Form::text('number', null, ['class' => 'form-control', 'placeholder' => 'Número:']) !!}
            </div>
            
            <div class="form-group">
                <label for="zip_code">Código Postal:</label>
                {!! Form::text('zip_code', null, ['class' => 'form-control', 'placeholder' => 'Código Postal:']) !!}
            </div>
            
            <div class="form-group">
                <label for="complement">Complemento:</label>
                {!! Form::text('complement', null, ['class' => 'form-control', 'placeholder' => 'Complemento:']) !!}
            </div>
            
            
            <div class="form-group">
                <button class="btn btn-search">Salvar</button>
            </div>
         {!! Form::close() !!}

    </div><!--Content Dinâmico-->

@endsection