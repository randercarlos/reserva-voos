@extends('panel.template.app')


@section('content')

    <div class="bred">
        <a href="{{ route('panel.index') }}" class="bred">Home  ></a>
        @if (isset($city))
            <a href="{{ route('state.cities', $city->state->initials) }}" class="bred">Cidade > {{ $city->name }}  ></a>
        @endif
        <a href="{{ isset($city) ? route('airports.city', $city->id) : route('airports.index') }}"
            class="bred">Aeroportos</a>
    </div>

    <div class="title-pg">
    	<h1 class="title-pg">Aeroportos{!! isset($city) ? " da cidade: <b>{$city->name}</b>" : '' !!}</h1>
    </div>


    <div class="content-din bg-white">

        {{--
        Desabilita a pesquisa quando essa view for usada para exibir aeroportos de uma cidade. Isso é
        determinado pela variável $city. Se estiver definida, o form de pesquisa não deve ser exibido, pois não
        existem mais que 3 aeroportos por cidade, logo não faz sentido exibi-lo
        --}}

        @unless (isset($city))
        <div class="form-search">

             {!! Form::open(['route' => 'airports.search', 'class' => 'form form-inline']) !!}

                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nome do Aeroporto...']) !!}

                {!! Form::select('city', $cities, null, ['class' => 'form-control', 'placeholder' => 'Cidade...']) !!}

                <button class="btn btn-search">Pesquisar</button>
                <a href="{{ route('airports.index') }}" class="btn btn-search">Exibir todos</a>
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
        @endunless

        <div class="messages">
            @include('panel.includes.alerts')
        </div>

        <div class="row-fluid">
            <div class="span6">
                <div class="class-btn-insert">
                    <a href="{{ route('airports.create') }}" class="btn-insert">
                        <span class="glyphicon glyphicon-plus"></span>
                        Cadastrar
                    </a>
                </div>
            </div>

            <div class="span6 pull-right" style="text-align:right">
                <div class="class-btn-insert">
                    <a href="{{ route('airports.report') }}" class="btn-report" target="_blank">
                        <span class="glyphicon glyphicon-file"></span>
                        Relatório em PDF
                    </a>
                </div>
            </div>

        </div>

        <table class="table table-striped">
            <tr>
                <th>Nome</th>
                <th>Cidade</th>
                <th class="text-center">Número</th>
                <th class="text-center">Latitude</th>
                <th class="text-center">Longitude</th>
                <th class="actions">Ações</th>
            </tr>

            @forelse($airports as $airport)
                <tr>
                    <td>{{ $airport->name }}</td>
                    <td>{{ $airport->city->name }} - {{ $airport->city->state->initials }}</td>
                    <td class="text-center">{{ $airport->number or '-' }}</td>
                    <td class="text-center">{{ $airport->latitude or '-'}}</td>
                    <td class="text-center">{{ $airport->longitude or '-'}}</td>
                    <td class="text-center">
                        <a href="{{ route('airports.edit', $airport->id) }}" class="edit">Editar</a>
                        <a href="{{ route('airports.show', $airport->id) }}" class="delete">Ver</a>
                     </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Nenhum registro encontrado!</td>
                </tr>
            @endforelse
        </table>

        <div class="centered text-center">
            {{-- # @if (isset($dataForm))
                {!! $airports->appends($dataForm)->links() !!}
            @else
                {!! $airports->links() !!}
            @endif --}}
        </div>
    </div><!--Content Dinâmico-->

@endsection
