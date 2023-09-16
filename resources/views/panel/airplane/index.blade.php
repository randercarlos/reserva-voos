@extends('panel.template.app')

@section('content')

    <div class="bred">
        <a href="" class="bred">Home  ></a>
        <a href="" class="bred">Airplanes</a>
    </div>

    <div class="title-pg">
    	<h1 class="title-pg">Aviões</h1>
    </div>


    <div class="content-din bg-white">

        <div class="form-search">

             {!! Form::open(['route' => 'airplanes.search', 'class' => 'form form-inline']) !!}
                {!! Form::text('q', null, ['class' => 'form-control',
                    'placeholder' => 'Informe os dados da pesquisa...', 'style' => 'width: 30%']) !!}

                <button class="btn btn-search">Pesquisar</button>
                <a href="{{ route('airplanes.index') }}" class="btn btn-search" role="button">Exibir todos</a>
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
                    <a href="{{ route('airplanes.create') }}" class="btn-insert">
                        <span class="glyphicon glyphicon-plus"></span>
                        Cadastrar
                    </a>
                </div>
            </div>

            <div class="span6 pull-right" style="text-align:right">
                <div class="class-btn-insert">
                    <a href="{{ route('airplanes.report') }}" class="btn-report" target="_blank">
                        <span class="glyphicon glyphicon-file"></span>
                        Relatório em PDF
                    </a>
                </div>
            </div>

        </div>

        <table class="table table-striped">
            <tr>
                <th>Nome</th>
                <th>Marca</th>
                <th>Classe</th>
                <th>Capacidade</th>
                <th class="actions">Ações</th>
            </tr>

            @forelse($airplanes as $airplane)
                <tr>
                    <td> {{ $airplane->name }}</td>
                    <td> {{ $airplane->brand->name }}</td>
                    <td> {{ $airplane->class }}</td>
                    <td> {{ $airplane->qty_passengers }}</td>
                    <td>
                        <a href="{{ route('airplanes.edit', $airplane->id) }}" class="edit">Editar</a>
                        <a href="{{ route('airplanes.show', $airplane->id) }}" class="delete">Ver</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Nenhum registro encontrado!</td>
                </tr>
            @endforelse
        </table>

        <div class="centered text-center">
            @if (isset($dataForm))
                {!! $airplanes->appends($dataForm)->links() !!}
            @else
                {!! $airplanes->links() !!}
            @endif
        </div>
    </div><!--Content Dinâmico-->


@endsection
