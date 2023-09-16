@extends('panel.template.app')

@section('css')
    <link rel="stylesheet" href="{{ url('assets/panel/lightbox/css/lightbox.min.css') }}">
@endsection

@section('content')

    <div class="bred">
        <a href="{{ route('panel.index') }}" class="bred">Home ></a>
        <a href="{{ route('flights.index') }}" class="bred">Aviões ></a>
        <a href="#" class="bred">{{ isset($flight) ? 'Editar' : 'Cadastrar' }}</a>
    </div>

    <div class="title-pg">
        <h1 class="title-pg">{{ isset($flight) ? "Editar Voo: {$flight->id} " : 'Cadastrar Voo' }}</h1>
    </div>

    <div class="content-din">

        @include('panel.includes.errors')


        @if (isset($flight))
            {!! Form::model($flight,['route' => ['flights.update', $flight->id],
                'class' => 'form form-search form-ds', 'method' => 'PUT', 'files' => true]) !!}
        @else
            {!! Form::open(['route' => 'flights.store', 'class' => 'form form-search form-ds', 'files' => true]) !!}
        @endif

            {!! csrf_field() !!}


            <div class="form-group">
                <label for="airplane_id">Avião:</label>
                {!! Form::select('airplane_id', $airplanes, null, ['class' => 'form-control',
                    'placeholder' => 'Selecione o avião...']) !!}
            </div>

            <div class="form-group">
                <label for="airport_origin_id">Origem:</label>
                {!! Form::select('airport_origin_id', $airports, null, ['class' => 'form-control',
                    'placeholder' => 'Selecione o aeroporto de chegada...']) !!}
            </div>

            <div class="form-group">
                <label for="airport_destination_id">Destino:</label>
                {!! Form::select('airport_destination_id', $airports, null, ['class' => 'form-control',
                    'placeholder' => 'Selecione o aeroporto de destino...']) !!}
            </div>

            <div class="form-group">
                <label for="date">Data:</label>
                {!! Form::text('date', null, ['class' => 'form-control', 'id' => 'date']) !!}
            </div>

            <div class="form-group" style="position: relative">
                <label for="time_duration">Duração:</label>
                {!! Form::time('time_duration', null, ['class' => 'form-control', 'id' => 'time_duration']) !!}
            </div>

            <div class="form-group">
                <label for="hour_output">Hora Saída:</label>
                {!! Form::time('hour_output', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                <label for="arrival_time">Hora Chegada:</label>
                {!! Form::time('arrival_time', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                <label for="old_price">Preço anterior:</label>
                {!! Form::text('old_price', null, ['class' => 'form-control', 'placeholder' => 'Preço anterior']) !!}
            </div>

            <div class="form-group">
                <label for="price">Preço:</label>
                {!! Form::text('price', null, ['class' => 'form-control', 'placeholder' => 'Preço']) !!}
            </div>

            <div class="form-group">
                <label for="total_plots">Total de Parcelas:</label>
                {!! Form::number('total_plots', null, ['class' => 'form-control',
                    'placeholder' => 'Total de parcelas']) !!}
            </div>

            <div class="form-group">
                {!! Form::checkbox('is_promotion', true, null, ['id' => 'is_promotion']) !!}
                <label for="is_promotion">É promoção ?</label>
            </div>

            <div class="form-group">
                <label for="image">Foto:</label>
                {!! Form::file('image', ['class' => 'form-control']) !!}
                @if (isset($flight->image))
                    <a href='{{ url("uploads/flights/{$flight->image}") }}' data-lightbox="Flights">
                        <img src='{{ url("uploads/flights/{$flight->image}") }}' alt="{{ $flight->id }}"
                        style="max-width: 200px; margin-top: 10px" />
                    </a>
                @endif

            </div>

            <div class="form-group">
                <label for="qty_stops">Quantidade de Paradas:</label>
                {!! Form::number('qty_stops', null, ['class' => 'form-control', 'placeholder' => 'Qtd. de paradas']) !!}
            </div>

            <div class="form-group">
                <label for="description">Descrição:</label>
                {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Descrição']) !!}
            </div>


            <div class="form-group">
                <button class="btn btn-search">Salvar</button>
            </div>
         {!! Form::close() !!}

    </div><!--Content Dinâmico-->

@endsection


@section('js')
    <script src="{{ url('assets/panel/lightbox/js/lightbox.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var nowTemp = new Date();
            var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

            $('#date').datepicker({
                format: "dd/mm/yyyy",
                language: "pt-BR",
                autoclose: true,
                beforeShowDay: function(date) {
                    return date.valueOf() >= now.valueOf();
                },
            });
        });
    </script>
@endsection
