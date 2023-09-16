@extends('site.template.app')

@section('content-site')

<div class="content">

    <section class="container">

        <h1 class="title">Promoções</h1>

        <div class="row">

            @forelse($promotions as $promotion)
                <article class="result col-lg-3 col-md-4 col-sm-6 col-12">

                        @if (isset($promotion?->image))
                        <img src='{{ asset("uploads/flights/{$promotion?->image}") }}'
                            alt="Voo #{{$promotion?->id}}" class="image-promo">
                        @else
                           <img src='{{ asset("assets/site/images/default_promotion_flight2.png") }}'
                            alt="Voo #{{$promotion?->id}}" class="image-promo">
                        @endif


                        <div class="legend">
                            <h1 style="font-size: 14px">
                                <span style="color: #BDBDBD;">Para:</span>
                                {{ $promotion?->destination?->city?->name }} -
                                {{ $promotion?->destination?->city?->state?->initials }}
                            </h1>
                            <h2 style="font-size: 14px">
                                <span style="color: #BDBDBD;">Saída:</span>
                                {{ $promotion?->origin?->city?->name }} -
                                {{ $promotion?->origin?->city?->state?->initials }}

                            </h2>
                            <span>Ida e Volta</span>
                        </div>

                        {{-- Utiliza acessor para imprimir a data formatada --}}
                        <p class="promotion-date-color">
                            Data: {{ $promotion?->departure_date }} às {{ $promotion?->hour_output }}
                        </p>

                        <div class="price">
                            <span>R$ {{ number_format($promotion?->price, 2, ',', '.') }}</span>
                            <strong>Em até {{ $promotion?->total_plots }}x</strong>
                        </div>

                        <a href="{{ route('site.flight.details', $promotion?->id) }}" class="btn btn-buy">
                            Saiba mais...
                        </a>

                </article><!--result-?->
            @empty

                <p>Nenhuma promoção encontrada!</p>

            @endforelse

        </div><!--Row-?->
    </section><!--Container-?->

</div>

@endsection
