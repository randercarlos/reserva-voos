@extends('panel.template.app')

@section('content')

    <div class="bred">
        <a href="{{ route('panel.index') }}" class="bred">Home  ></a>
        <a href="" class="bred">Usuários</a>
    </div>

    <div class="title-pg">
    	<h1 class="title-pg">Usuários</h1>
    </div>


    <div class="content-din bg-white">

        <div class="form-search">

             {!! Form::open(['route' => 'users.search', 'class' => 'form form-inline']) !!}
                {!! Form::text('q', null, ['class' => 'form-control',
                    'placeholder' => 'Pesquisar por nome ou email...', 'style' => 'width: 30%']) !!}

                <button class="btn btn-search">Pesquisar</button>
                <a href="{{ route('users.index') }}" class="btn btn-search">Exibir todos</a>
             {!! Form::close() !!}


        </div>

        <div class="messages">
            @include('panel.includes.alerts')
        </div>

         <div class="row-fluid">
            <div class="span6">
                <div class="class-btn-insert">
                    <a href="{{ route('users.create') }}" class="btn-insert">
                        <span class="glyphicon glyphicon-plus"></span>
                        Cadastrar
                    </a>
                </div>
            </div>

            <div class="span6 pull-right" style="text-align:right">
                <div class="class-btn-insert">
                    <a href="{{ route('users.report') }}" class="btn-report" target="_blank">
                        <span class="glyphicon glyphicon-file"></span>
                        Relatório em PDF
                    </a>
                </div>
            </div>

        </div>

        <table class="table table-striped" style="margin-bottom: 0">
            <tr>
                <th style="width: 150px;">Imagem</th>
                <th>Nome</th>
                <th>Email</th>
                <th style="text-align: center;">É admin ?</th>
                <th class="actions">Ações</th>
            </tr>

            @forelse($users as $user)
                <tr>
                    <td>
                        @if (isset($user->image))
                            <img src='{{ url("uploads/users/{$user->image}") }}' alt="{{ $user->id }}"
                                style="width: 60px" />
                        @else
                            <img src='{{ url("assets/panel/imgs/user.png") }}' alt="{{ $user->id }}"
                                style="width: 60px" />
                        @endif
                    </td>
                    <td> {{ $user->name }}</td>
                    <td> {{ $user->email }}</td>
                    <td style="text-align: center;"> {{ $user->is_admin ? 'Sim' : 'Não' }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="edit">Editar</a>
                        <a href="{{ route('users.show', $user->id) }}" class="delete">Ver</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Nenhum registro encontrado!</td>
                </tr>
            @endforelse
        </table>

        <div class="centered text-center">
            @if (isset($dataForm))
                {!! $users->appends($dataForm)->links() !!}
            @else
                {!! $users->links() !!}
            @endif
        </div>
    </div><!--Content Dinâmico-->


@endsection
