@extends('panel.template.app')

@section('content')

    <div class="bred">
        <a href="{{ route('panel.index') }}" class="bred">Home  ></a>
        <a href="" class="bred">Reservas</a>
    </div>

    <div class="title-pg">
    	<h1 class="title-pg">Reservas</h1>
    </div>


    <div class="content-din bg-white">

        <div class="form-search">

             {!! Form::open(['route' => 'reserves.search', 'class' => 'form form-inline']) !!}
                {!! Form::text('user', null, ['class' => 'form-control',
                    'placeholder' => 'Pesquisar pelo nome do usuário...', 'style' => 'width: 15%']) !!}

                {!! Form::text('reserve', null, ['class' => 'form-control',
                    'placeholder' => 'Pesquisar pelo id da reserva...', 'style' => 'width: 15%']) !!}

                {!! Form::date('date', null, ['class' => 'form-control',
                    'placeholder' => 'Pesquisar pela data...', 'style' => 'width: 15%']) !!}

                {!! Form::select('status', $status, null, ['class' => 'form-control',
                    'placeholder' => 'Pesquisar por status...', 'style' => 'width: 15%']) !!}

                <button class="btn btn-search">Pesquisar</button>
                <a href="{{ route('reserves.index') }}" class="btn btn-search" role="button">Exibir todos</a>
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
                    <a href="{{ route('reserves.create') }}" class="btn-insert">
                        <span class="glyphicon glyphicon-plus"></span>
                        Cadastrar
                    </a>
                </div>
            </div>

            <div class="span6 pull-right" style="text-align:right">
                <div class="class-btn-insert">
                    <a href="{{ route('reserves.report') }}" class="btn-report" target="_blank">
                        <span class="glyphicon glyphicon-file"></span>
                        Relatório em PDF
                    </a>
                </div>
            </div>


        <table class="table table-striped">
            <tr>
                <th class="text-center" width="60">#Id</th>
                <th>Usuário</th>
                <th class="text-center">Voo</th>
                <th class="text-center">Data Reserva</th>
                <th class="text-center">Status</th>
                <th class="actions">Ações</th>
            </tr>

            @forelse($reserves as $reserve)
                <tr>
                    <td class="text-center"> {{ $reserve->id }}</td>
                    <td> {{ $reserve->user->name }}</td>
                    <td class="text-center"> {{ $reserve->flight_id }}({{ formatDateAndTime($reserve->flight->date) }})</td>
                    <td class="text-center"> {{ formatDateAndTime($reserve->date_reserved) }}</td>
                    <td class="text-center">
                        <span class="badge badge-primary" style="font-size: 14px">
                            {{ $reserve->getStatus($reserve->status) }}
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('reserves.edit', $reserve->id) }}" class="edit">Editar</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Nenhum registro encontrado!</td>
                </tr>
            @endforelse
        </table>

        <div class="centered text-center">
            @if (isset($dataForm))
                {!! $reserves->appends($dataForm)->links() !!}
            @else
                {!! $reserves->links() !!}
            @endif
        </div>
    </div><!--Content Dinâmico-->


@endsection
