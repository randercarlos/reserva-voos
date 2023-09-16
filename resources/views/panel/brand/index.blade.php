@extends('panel.template.app')

@section('content')

    <div class="bred">
        <a href="{{ route('panel.index') }}" class="bred">Home  ></a>
        <a href="" class="bred">Marcas</a>
    </div>

    <div class="title-pg">
    	<h1 class="title-pg">Marcas de Aviões</h1>
    </div>


    <div class="content-din bg-white">

        <div class="form-search">

             {!! Form::open(['route' => 'brands.search', 'class' => 'form form-inline']) !!}
                {!! Form::text('q', null, ['class' => 'form-control',
                    'placeholder' => 'Informe os dados da pesquisa...', 'style' => 'width: 30%']) !!}

                <button class="btn btn-search">Pesquisar</button>
                <a href="{{ route('brands.index') }}" class="btn btn-search">Exibir todos</a>
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
                    <a href="{{ route('brands.create') }}" class="btn-insert">
                        <span class="glyphicon glyphicon-plus"></span>
                        Cadastrar
                    </a>
                </div>
            </div>

            <div class="span6 pull-right" style="text-align:right">
                <div class="class-btn-insert">
                    <a href="{{ route('brands.report') }}" class="btn-report" target="_blank">
                        <span class="glyphicon glyphicon-file"></span>
                        Relatório em PDF
                    </a>
                </div>
            </div>

        </div>

        <table class="table table-striped">
            <tr>
                <th>Nome</th>
                <th class="actions">Ações</th>
            </tr>

            @forelse($brands as $brand)
                <tr>
                    <td> {{ $brand->name }}</td>
                    <td>
                        <a href="{{ route('brands.edit', $brand->id) }}" class="edit">Editar</a>
                        <a href="{{ route('brands.show', $brand->id) }}" class="delete">Ver</a>
                        <a href="{{ route('brands.airplanes', $brand->id) }}" class="edit">
                            <i class="fa fa-plane" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">Nenhum registro encontrado!</td>
                </tr>
            @endforelse
        </table>

        <div class="centered text-center">
            @if (isset($dataForm))
                {!! $brands->appends($dataForm)->links() !!}
            @else
                {!! $brands->links() !!}
            @endif
        </div>
    </div><!--Content Dinâmico-->


@endsection
