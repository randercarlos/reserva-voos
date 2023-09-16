@extends('panel.template.app')

@section('content')

    <div class="bred">
        <a href="{{ route('panel.index') }}" class="bred">Home ></a> 
        <a href="{{ route('users.index') }}" class="bred">Usuários ></a>
        <a href="#" class="bred">Detalhe</a>
    </div>
        
    <div class="title-pg">
    	<h1 class="title-pg">Detalhes do Usuário</h1>
    </div>


    <div class="content-din">
        
        <table class="table table-striped" style="width: 35%">
            <tr>
                <th style='vertical-align: middle;'>Imagem</th>
                <td>
                    @if (isset($user->image))
                        <img src='{{ url("uploads/users/{$user->image}") }}' alt="{{ $user->id }}" 
                            style="width: 60px" />
                    @else
                        <img src='{{ url("assets/panel/imgs/user.png") }}' alt="{{ $user->id }}" 
                            style="width: 60px" />
                    @endif
                </td>
            </tr>
            <tr>
                <th>Nome</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>É admin ?</th>
                <td>{{ $user->is_admin ? 'Sim' : 'Não' }}</td>
            </tr>
        </table>
        
        
        {!! Form::open(['route' => ['users.destroy', $user->id], 'class' => 'form form-search form-ds', 
            'method' => 'DELETE']) !!}

            <div class="form-group">
                <button class="btn btn-danger">Deletar o Usuário {{ $user->id }} </button>
            </div>
            
        {!! Form::close() !!}

    </div><!--Content Dinâmico-->
    
@endsection