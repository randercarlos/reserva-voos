@extends('site.template.app')


@section('content-site')

<div class="content">

    <section class="container">
        <h1 class="title">Detalhes do Voo #{{ $flight->id }}</h1>

        <ul>
            <li>Código: <strong>{{ $flight->airplane_id }}</strong>
            <li>Origem: <strong>{{ $flight->origin->name }} - {{ $flight->origin->city->name }}</strong>
            <li>Destino: <strong>{{ $flight->destination->name }} - {{ $flight->destination->city->name }}</strong>
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
        </ul>
        
        <div class="class-btn-insert">
            <a href="{{ route('site.purchases') }}" class="btn-button">
                Voltar para Minhas Compras
            </a>
        </div>
        
    </section><!--Container-->

</div>

@endsection