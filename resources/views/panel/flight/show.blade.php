@extends('panel.template.app')

@section('css')
    <link rel="stylesheet" href="{{ url('assets/panel/lightbox/css/lightbox.min.css') }}">
@endsection

@section('content')

    <div class="bred">
        <a href="{{ route('panel.index') }}" class="bred">Home ></a> 
        <a href="{{ route('flights.index') }}" class="bred">Voos ></a>
        <a href="#" class="bred">Detalhe</a>
    </div>
        
    <div class="title-pg">
    	<h1 class="title-pg">Detalhes do Voo</h1>
    </div>


    <div class="content-din">
        
         <table class="table table-striped" style="width: 40%">
            <tr>
                <th>Código</th>
                <td>{{ $flight->airplane_id }}</td>
            </tr>
            <tr>
                <th>Origem</th>
                <td>{{ $flight->origin->name }}</td>
            </tr>
            <tr>
                <th>Destino</th>
                <td>{{ $flight->destination->name }}</td>
            </tr>
            <tr>
                <th>Data</th>
                <td>{{ formatDateAndTime($flight->date) }}</td>
            </tr>
            <tr>
                <th>Duração</th>
                <td>{{ formatDateAndTime($flight->time_duration, 'H:i') }}</td>
            </tr>
            <tr>
                <th>Saída</th>
                <td>{{ formatDateAndTime($flight->hour_output, 'H:i') }}</td>
            </tr>
            <tr>
                <th>Chegada</th>
                <td>{{ formatDateAndTime($flight->arrival_time, 'H:i') }}</td>
            </tr>
            <tr>
                <th>Preço anterior:</th>
                <td>R$ {{ number_format($flight->old_price, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Preço atual</th>
                <td>R$ {{ number_format($flight->price, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Total de parcelas</th>
                <td>{{ $flight->total_plots }}</td>
            </tr>
            <tr>
                <th>Promoção</th>
                <td>{{ $flight->is_promotion ? 'Sim' : 'Não' }}</td>
            </tr>
            <tr>
                <th>Preço atual</th>
                <td>{{ formatDateAndTime($flight->date) }}</td>
            </tr>
            <tr>
                <th>Paradas</th>
                <td>{{ $flight->qty_stops }}</td>
            </tr>
            <tr>
                <th>Descrição</th>
                <td>{{ $flight->description }}</td>
            </tr>
            <tr>
                <th style='vertical-align: middle;'>Imagem</th>
                <td>
                    @if (isset($flight->image))
                        <a href='{{ url("uploads/flights/{$flight->image}") }}' 
                            data-lightbox="flight-{{ $flight->id }}">
                            <img src='{{ url("uploads/flights/{$flight->image}") }}' alt="{{ $flight->id }}" 
                            style="width: 100px" />
                        </a>
                    @else
                        <img src='{{ url("assets/panel/imgs/airplane.png") }}' alt="{{ $flight->id }}" 
                            style="width: 60px" />
                    @endif
                </td>
            </tr>
        </table>
            
        
        {!! Form::open(['route' => ['flights.destroy', $flight->id], 'class' => 'form form-search form-ds', 
            'method' => 'DELETE']) !!}

            <div class="form-group">
                <button class="btn btn-danger">Deletar o Voo {{ $flight->id }} </button>
            </div>
            
        {!! Form::close() !!}

    </div><!--Content Dinâmico-->
    
@endsection


@section('js')
    <script src="{{ url('assets/panel/lightbox/js/lightbox.min.js') }}"></script>
@endsection