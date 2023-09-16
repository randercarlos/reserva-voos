@extends('panel.template.app')

@section('content')

    <div class="bred">
        <a href="{{ route('panel.index') }}" class="bred">Home  ></a>
        <a href="{{ route('states.index') }}" class="bred">Estados ></a>
        <a href="{{ route('state.cities', $state->id) }}" class="bred">{{ $state->name }} ></a>
        <a href="" class="bred">Cidades</a>
    </div>

    <div class="title-pg">
    	<h1 class="title-pg">Cidades do Estado({{ $cities->total() }}): <b>{{ $state->name }}</b></h1>
    </div>


    <div class="content-din bg-white">

        <div class="form-search">

             {!! Form::open(['route' => ['state.cities.search', $state->initials], 'class' => 'form form-inline']) !!}
                {!! Form::text('q', null, ['class' => 'form-control',
                    'placeholder' => 'Informe os dados da pesquisa...', 'style' => 'width: 30%']) !!}

                <button class="btn btn-search">Pesquisar</button>
                <a href="{{ route('states.index') }}" class="btn btn-search" role="button">Exibir todos</a>
             {!! Form::close() !!}

             {{-- Se o usuário clicou no botão de pesquisar, exibe o termo pesquisado --}}
             @if (isset($dataForm['q']))
                <div class="alert alert-info">
                    <p>
                        Resultados para cidades que contenham: <b>{{ $dataForm['q'] }}</b>
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
                <th style="text-align: center">CEP</th>
                <th class="actions">Ações</th>
            </tr>

            @forelse($cities as $city)
                <tr>
                    <td> {{ $city->name }}</td>
                    <td style="text-align: center"> {{ $city->zip_code or '-' }}</td>
                    <td>
                        <a href="{{ route('airports.city', $city->id) }}" class="edit">
                            <i class="fa fa-thumb-tack" aria-hidden="true"></i> Aeroportos
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Nenhum registro encontrado!</td>
                </tr>
            @endforelse
        </table>


         <div class="centered text-center">
             @if (isset($dataForm))
                {!! $cities->appends($dataForm)->links() !!}
            @else
                {!! $cities->links() !!}
            @endif
         </div>

    </div><!--Content Dinâmico-->


@endsection
