@extends('site.template.app')

@section('content-site')


<section class="slide"></section><!--Slide-->

    <div class="actions-form">
        <h2>Encontre: </h2>

          {!! Form::open(['route' => 'site.flights.search', 'class' => 'form-home text-center']) !!}

              {!! csrf_field() !!}

            <div class="form-group">
                {!! Form::select('origin', $airports, null, ['class' => 'form-control',
                    'placeholder' => 'Selecione a origem...', 'required' => false]) !!}
            </div>


            <div class="form-group">
                {!! Form::select('destination', $airports, null, ['class' => 'form-control',
                    'placeholder' => 'Selecione o destino...', 'required' => false]) !!}
            </div>


            <div class="form-group">
                <div class="col-sm-12">
                    {{ Form::radio('filter_date', 'apos', true) }}<label class="label_date">A partir de </label>
                    {{ Form::radio('filter_date', 'igual') }}<label class="label_date">Na data de </label>

                    {!! Form::date('date', now(), ['class' => 'col-sm-8', 'required' => true]) !!}
                </div>
            </div>


            <button class="btn" type="submit">
                Procurar <i class="fa fa-search" aria-hidden="true"></i>
            </button>
        {!! Form::close() !!}

    </div><!--actions-form-->

    <div class="rectangle"></div><!--rectangle-->

    <div class="clear"></div>

    <section class="banner">
        <div class="container banner-ctc-background-over-white card">
            <div class="row">
                <div class="col-md-3 text-center">
                    <img class="banner-ctc-img" src="{{ url('assets/site/images/cards.png') }}">
                </div>
                <div class="col-md-7">

                    <div class="banner-ctc-titulo-contenedor">
                        <span>Deseja Reservar passagens áreas para mais de 150 destinos em todo o mundo ?</span>
                    </div>

                    <div>
                        <p>A VIAJEBEM JÁ ATENDEU MAIS DE 500 MIL CLIENTES E É LIDER DE MERCADO NO SEGMENTO
                        DE VIAGENS TURÍSTICAS. </p>

                        <p>VIAJE CONOSCO. TEREMOS O MAIOR PRAZER EM FAZER A SUA VIAGEM COM SEGURANÇA E COMODIDADE.</p>
                    </div>

                </div>
                <div class="col-md-2">
                    <a href="#" target="_blank"
                        class="btn pull-right btn-flat flat-medium third-level">
                        <span>Saiba Mais</span>
                    </a>
                </div>
            </div>
        </div>
    </section><!--Banner-->


@endsection
