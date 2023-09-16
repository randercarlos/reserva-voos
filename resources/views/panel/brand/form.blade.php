@extends('panel.template.app')

@section('content')

    <div class="bred">
        <a href="{{ route('panel.index') }}" class="bred">Home ></a>
        <a href="{{ route('brands.index') }}" class="bred">Marcas ></a>
        <a href="#" class="bred">{{ isset($brand) ? 'Editar' : 'Cadastrar' }}</a>
    </div>

    <div class="title-pg">
        <h1 class="title-pg">{{ isset($brand) ? "Editar Marca: {$brand->name} " : 'Cadastrar Marca' }}</h1>
    </div>

    <div class="content-din">

        @include('panel.includes.errors')


        @if (isset($brand))
            {!! Form::model($brand,['route' => ['brands.update', $brand->id],
                'class' => 'form form-search form-ds', 'method' => 'PUT']) !!}
            {!! csrf_field() !!}
        @else
            {!! Form::open(['route' => 'brands.store', 'class' => 'form form-search form-ds']) !!}
        @endif
            {!! csrf_field() !!}

            <div class="form-group">
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nome:']) !!}
            </div>

            <div class="form-group">
                <button class="btn btn-search">Salvar</button>
            </div>
         {!! Form::close() !!}

    </div><!--Content Dinâmico-->

@endsection
