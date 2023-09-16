@extends('panel.template.app')


@section('content')

    <div class="bred">
        <a href="{{ route('panel.index') }}" class="bred">Home ></a> 
        <a href="{{ route('reserves.index') }}" class="bred">Reservas ></a>
        <a href="#" class="bred">{{ isset($reserve) ? 'Editar' : 'Reservar' }}</a>
    </div>

    <div class="title-pg">
        <h1 class="title-pg">{!! isset($reserve) ? "Editar Reserva do Usuário: <b>{$reserve->user->name}</b> " : 
            'Nova Reserva' !!}</h1>
    </div>

    <div class="content-din">
    
        @include('panel.includes.errors')
            
            
        @if (isset($reserve))
            {!! Form::model($reserve,['route' => ['reserves.update', $reserve->id], 
                'class' => 'form form-search form-ds', 'method' => 'PUT']) !!}
        @else
            {!! Form::open(['route' => 'reserves.store', 'class' => 'form form-search form-ds']) !!}
        @endif
        
            {!! csrf_field() !!}
    
    
        {{-- Na edição da reserva, somente o status pode ser alterado --}}
        @if (!isset($reserve))
            
            <div class="form-group">
                <label for="user_id">Usuário:</label>
                {!! Form::select('user_id', $users, null, ['class' => 'form-control', 
                    'placeholder' => 'Selecione o usuário...']) !!}
            </div>
            
            <div class="form-group">
                <label for="flight_id">Voo:</label>
                {!! Form::select('flight_id', $flights, null, ['class' => 'form-control', 
                    'placeholder' => 'Selecione o Voo...']) !!}
            </div>
            
            
            <div class="form-group">
                <label for="date_reserved">Data Reserva:</label>
                {!! Form::date('date_reserved', date('Y-m-d'), ['class' => 'form-control']) !!}
            </div>
    
        @endif
        
            
            <div class="form-group">
                <label for="status">Status:</label>
                {!! Form::select('status', $status, null, ['class' => 'form-control', 
                    'placeholder' => 'Selecione o Status...']) !!}
            </div>

            <div class="form-group">
                <button class="btn btn-search">Salvar</button>
            </div>
         {!! Form::close() !!}

    </div><!--Content Dinâmico-->

@endsection

