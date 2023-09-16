@extends('panel.template.app')

@section('css')
    <link rel="stylesheet" href="{{ url('assets/panel/lightbox/css/lightbox.min.css') }}">
@endsection

@section('content')

    <div class="bred">
        <a href="{{ route('panel.index') }}" class="bred">Home  ></a>
        <a href="" class="bred">Voos</a>
    </div>

    <div class="title-pg">
    	<h1 class="title-pg">Voos</h1>
    </div>


    <div class="content-din bg-white">

        <div class="form-search">

             {!! Form::open(['route' => 'flights.search', 'class' => 'form form-inline']) !!}
                {!! Form::number('code', null, ['class' => 'form-control',
                    'placeholder' => 'Código do Voo']) !!}

                {!! Form::date('date', null, ['class' => 'form-control',
                    'placeholder' => 'Data']) !!}

                {!! Form::time('hour_output', null, ['class' => 'form-control',
                    'placeholder' => 'Saída']) !!}

                {!! Form::number('total_stops', null, ['class' => 'form-control',
                    'placeholder' => 'Total de Paradas']) !!}

                 {!! Form::select('origin', $airports, null, ['class' => 'form-control',
                    'placeholder' => 'Origem...']) !!}

                 {!! Form::select('destination', $airports, null, ['class' => 'form-control',
                    'placeholder' => 'Destino...']) !!}

                <button class="btn btn-search">Pesquisar</button>
                <a href="{{ route('flights.index') }}" class="btn btn-search">Exibir todos</a>
             {!! Form::close() !!}

             {{-- Se o usuário clicou no botão de pesquisar, exibe o termo pesquisado --}}
             @if (isset($dataForm['q']))
                <div class="alert alert-info">
                    <p>
                        Resultados para: <b>{{ $dataForm['q'] }}</b>
                    </p>
                </div>
             @endif

        </div>

        <div class="messages">
            @include('panel.includes.alerts')
        </div>

        <div class="row-fluid">
            <div class="span6">
                <div class="class-btn-insert">
                    <a href="{{ route('flights.create') }}" class="btn-insert">
                        <span class="glyphicon glyphicon-plus"></span>
                        Cadastrar
                    </a>
                </div>
            </div>

            <div class="span6 pull-right" style="text-align:right">
                <div class="class-btn-insert">
                    <a href="{{ route('flights.report') }}" class="btn-report" target="_blank">
                        <span class="glyphicon glyphicon-file"></span>
                        Relatório em PDF
                    </a>
                </div>
            </div>

        </div>

        <table class="table table-striped">
            <tr>
                <th>#</th>
                <th>Imagem</th>
                <th>Origem</th>
                <th>Destino</th>
                <th>Paradas</th>
                <th>Data</th>
                <th>Saída</th>
                <th class="actions">Ações</th>
            </tr>

            @forelse($flights as $flight)
                <tr>
                    <td> {{ $flight->id }}</td>
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
                    <td>
                        <a href="{{ route('airports.show', $flight->origin->id) }}">
                            {{ $flight->origin->name }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('airports.show', $flight->destination->id) }}">
                            {{ $flight->destination->name }}
                        </a>
                    </td>
                    <td> {{ $flight->qty_stops }}</td>
                    <td> {{ formatDateAndTime($flight->date) }}</td>
                    <td> {{ formatDateAndTime($flight->hour_output, 'H:i') }}</td>
                    <td>
                        <a href="{{ route('flights.edit', $flight->id) }}" class="edit">Editar</a>
                        <a href="{{ route('flights.show', $flight->id) }}" class="delete">Ver</a>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Nenhum registro encontrado!</td>
                </tr>
            @endforelse
        </table>

        <div class="centered text-center">
            {{-- # @if (isset($dataForm))
                {!! $flights->appends($dataForm)->links() !!}
            @else
                {!! $flights->links() !!}
            @endif --}}
        </div>
    </div><!--Content Dinâmico-->

@endsection


@section('js')
    <script src="{{ url('assets/panel/lightbox/js/lightbox.min.js') }}"></script>
@endsection
