@extends('site.template.app')

@section('css')
    <link rel="stylesheet" href="{{ url('assets/panel/lightbox/css/lightbox.min.css') }}">
@endsection

@section('content-site')

<div class="content">

    <section class="container">
    
        <div class="messages">
              @include('panel.includes.errors')
        </div>
        
        <h1 class="title">Detalhes do Voo #{{ $flight->id }}</h1>

        <ul>
            <li>Código: <strong>{{ $flight->id }}</strong>
            <li>Origem: <strong>{{ $flight->origin->name }}</strong>
            <li>Destino: <strong>{{ $flight->destination->name }}</strong>
            <li>Data: <strong>{{ formatDateAndTime($flight->date) }}</strong>
            <li>Duração: <strong>{{ formatDateAndTime($flight->time_duration, 'H:i') }}</strong>
            <li>Saída: <strong>{{ formatDateAndTime($flight->hour_output, 'H:i') }}</strong>
            <li>Chegada: <strong>{{ formatDateAndTime($flight->arrival_time, 'H:i') }}</strong>
            <li>Preço anterior: <strong>R$ {{ number_format($flight->old_price, 2, ',', '.') }}</strong>
            <li>Preço atual: <strong>R$ {{ number_format($flight->price, 2, ',', '.') }}</strong>
            <li>Total de parcelas: <strong>{{ $flight->total_plots }}</strong>
            <li>Promoção: <strong>{{ $flight->is_promotion ? 'SIM' : 'NÃO' }}</strong>
            <li>Paradas: <strong>{{ $flight->qty_stops }}</strong>
            <li>Descrição: <strong>{{ $flight->description }}</strong>
            {{--<li>Imagem: 
             <strong>
                <a href='{{ url("uploads/flights/{$flight->image}") }}' data-lightbox="flight-{{ $flight->id }}">
                    <img src='{{ url("uploads/flights/{$flight->image}") }}' alt="{{ $flight->id }}" 
                    style="width: 100px" />
                </a>
            </strong> --}}
        </ul>
        
        
        {!! Form::open(['route' => 'site.reserve.flight']) !!}
        
        {{-- Esses campos hidden são necessários, pois a ReserveValidatorFormRequest exigem que esses campos
            estejam na request para que ela possa ser validada  --}}
            
            {!! Form::hidden('user_id', auth()->user()->id) !!}
            {!! Form::hidden('flight_id', $flight->id) !!}
            {!! Form::hidden('date_reserved', date('Y-m-d')) !!}
            {!! Form::hidden('status', 'reserved') !!}
        
            <input type="submit" value="Reservar agora" class="btn btn-success" />
        {!! Form::close() !!}
        
        
    </section><!--Container-->

</div>

@endsection


@section('js')
    <script src="{{ url('assets/panel/lightbox/js/lightbox.min.js') }}"></script>
@endsection