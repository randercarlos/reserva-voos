@extends('panel.template.app')

@section('content')

    <div class="bred">
        <a href="" class="bred">Home  ></a>
        <a href="" class="bred">Estados</a>
    </div>

    <div class="title-pg">
    	<h1 class="title-pg">Estados</h1>
    </div>


    <div class="content-din bg-white">

        <div class="form-search">

             {!! Form::open(['route' => 'states.search', 'class' => 'form form-inline']) !!}
                {!! Form::text('q', null, ['class' => 'form-control',
                    'placeholder' => 'Informe os dados da pesquisa...', 'style' => 'width: 30%']) !!}

                <button class="btn btn-search">Pesquisar</button>
                <a href="{{ route('states.index') }}" class="btn btn-search" role="button">Exibir todos</a>
             {!! Form::close() !!}

             {{-- Se o usuário clicou no botão de pesquisar, exibe o termo pesquisado --}}
             @if (isset($dataForm['q']))
                <div class="alert alert-info">
                    <p>
                        Resultados para o Estado que contenha: <b>{{ $dataForm['q'] }}</b>
                    </p>
                </div>
             @endif

        </div>

        <div class="messages">
            @include('panel.includes.alerts')
        </div>


        <table class="table table-striped">
            <tr>
                <th>Nome</th>
                <th>Sigla</th>
                <th class="actions">Ações</th>
            </tr>

            @forelse($states as $state)
                <tr>
                    <td> {{ $state->name }}</td>
                    <td> {{ $state->initials }}</td>
                    <td>
                        <a href="{{ route('state.cities', $state->initials) }}" class="edit">
                            <i class="fa fa-map-marker" aria-hidden="true"></i> Cidades
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">Nenhum registro encontrado!</td>
                </tr>
            @endforelse
        </table>

    </div><!--Content Dinâmico-->


@endsection
