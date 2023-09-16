@extends('site.template.app')

@section('content-site')

<div class="content">

    <section class="container">

        <h1 class="title">{{ $title }}</h1>

        <div class="key-search row">

            <div class="col-lg-2 col-md-2 col-sm-12 col-12 text-center">
                <img src="{{ asset('assets/site/images/airplane_icon.png') }}" />
            </div>

            <div class="col-lg-10 col-md-10 col-sm-12 col-12">
                <p>
                    <span>De:</span>
                    <span class="flight-search">
                        {{ isset($origin->name) ? $origin->name . ' - '  .
                        $origin->city->name . '(' . $origin->city->state->initials  . ')' : 'Qualquer Aeroporto'}}
                    </span>
                </p>

                <p>
                    <span>Para:</span>
                    <span class="flight-search">
                        {{ isset($destination->name) ? $destination->name . ' - ' .
                        $destination->city->name  . '(' . $origin->city->state->initials  . ')' : 'Qualquer Aeroporto'}}
                    </span>
                 </p>
                <p>
                    <span>
                        {{ $filter_date == 'igual' ? 'Data' : 'A partir de'}}:
                    </span>
                    <span class="flight-search">{{ $date }}</span>
                </p>
            </div>

        </div>


        <div class="row results-search">
            @forelse($flights as $flight)
                <article class="result-search col-12">

                    <div>
                    <span>Voo: <strong>#{{ $flight->id }}</strong></span>
                    <span>Data: <strong>{{ formatDateAndTime($flight->date) }}</strong></span>
                    <span>Saída: <strong>{{ $flight->hour_output }}</strong></span>
                    <span>Chegada: <strong>{{ $flight->arrival_time }}</strong></span>
                    <span>Paradas: <strong>{{ $flight->qty_stops }}</strong></span>
                    <span>Preço:  <strong>R$ {{ number_format($flight->price, 2, ',', '.') }}</strong></span>

                    <a href="{{ route('site.flight.details', $flight->id) }}">Detalhes Voo</a>
                    </div>
                    <div>
                    <span>Descrição: <strong>{{  Str::limit($flight->description, 50) }}</strong></span>
                    </div>
                </article><!--result-search-->


            @empty
                <p style="width: 100%; text-align: center;">Nenhum resultado encontrado para essa pesquisa!</p>
            @endforelse
        </div><!--Row-->
    </section><!--Container-->

</div>

@endsection
