@extends('panel.template.app')

@section('css')
    <link rel="stylesheet" href="{{ url('assets/panel/lightbox/css/lightbox.min.css') }}">
@endsection

@section('content')

    <div class="bred">
        <a href="{{ route('panel.index') }}" class="bred">Home ></a> 
        <a href="{{ route('users.index') }}" class="bred">Usuários ></a>
        <a href="#" class="bred">{{ isset($user) ? 'Editar' : 'Cadastrar' }}</a>
    </div>

    <div class="title-pg">
        <h1 class="title-pg">{{ isset($user) ? "Editar Usuário: {$user->name} " : 'Cadastrar Usuário' }}</h1>
    </div>

    <div class="content-din">
    
        @include('panel.includes.errors')
            
            
        @if (isset($user))
            {!! Form::model($user,['route' => ['users.update', $user->id], 
                'class' => 'form form-search form-ds', 'method' => 'PUT', 'files' => true]) !!}
            {!! csrf_field() !!}
        @else
            {!! Form::open(['route' => 'users.store', 'class' => 'form form-search form-ds', 'files' => true]) !!}
        @endif
            {!! csrf_field() !!}

            <div class="form-group">
                <label for="name">Nome:</label>
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nome completo...']) !!}
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Email...']) !!}
            </div>
            
            <div class="form-group">
                <label for="password">Senha:</label>
                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Senha...']) !!}
            </div>
            
             <div class="form-group">
                <label for="password_confirm">Confirmar senha:</label>
                {!! Form::password('password_confirm', ['class' => 'form-control', 
                    'placeholder' => 'Confirmar senha...']) !!}
            </div>
            
            <div class="form-group">
                <label for="image">Imagem:</label>
                {!! Form::file('image', ['class' => 'form-control']) !!}
                 @if (isset($user->image))
                    <a href='{{ url("uploads/users/{$user->image}") }}' data-lightbox="Users">
                        <img src='{{ url("uploads/users/{$user->image}") }}' alt="{{ $user->id }}" 
                        style="width: 70px; margin: 20px 0 10px 0" />
                    </a>
                @endif
            </div>
            
            <div class="form-group">
                <label for="is_admin">É admin ?</label>
                {!! Form::checkbox('is_admin') !!}
            </div>

            <div class="form-group">
                <button class="btn btn-search">Salvar</button>
            </div>
         {!! Form::close() !!}

    </div><!--Content Dinâmico-->

@endsection

@section('js')
    <script src="{{ url('assets/panel/lightbox/js/lightbox.min.js') }}"></script>
@endsection