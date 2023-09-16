@extends('site.template.app')

@section('content-site')

<div class="content">

    <section class="container">
        <h1 class="title">Meu Perfil</h1>
         
         
        <div class="messages">
            @include('panel.includes.alerts')
        </div> 
        
        
        @include('panel.includes.errors')
        

        <div class="">
             {!! Form::model(auth()->user(), ['route' => 'site.user.update_profile', 'class' => 'form-eti', 
                'files' => true]) !!}
        
                <div class="form-group">
                    <label for="name">Nome *</label>

                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <div class="input-group-addon">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </div>
                        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nome...']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">E-Mail *</label>

                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <div class="input-group-addon">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </div>
                        {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email...', 
                            'readonly']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label for="image">Imagem: (Opcional) Informe Apenas se Quiser Atualizar</label>

                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <div class="input-group-addon">
                            <i class="fa fa-picture-o" aria-hidden="true"></i>
                        </div>
                        
                        {!! Form::file('image', ['class' => 'form-control']) !!}
                    </div>
                    
                    @if (auth()->user()->image)
                        <img src="{{ asset('uploads/users/' . auth()->user()->image) }}" 
                            alt="{{ auth()->user()->name }}" style="width: 100px; margin-top: 10px">
                    @endif                    
                    
                </div>

                <div class="form-group">
                    <label for="password">Senha: (Opcional) Informe Apenas se Quiser Atualizar</label>

                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <div class="input-group-addon">
                            <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                        </div>
                        
                        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Senha...']) !!}
                    </div>
                </div>
                
                
                <div class="form-group">
                    <label for="password_confirm">Confirmar senha: </label>

                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <div class="input-group-addon">
                            <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                        </div>
                        
                        {!! Form::password('password_confirm', ['class' => 'form-control', 
                            'placeholder' => 'Confirmar Senha...']) !!}
                    </div>
                </div>


                <button type="submit" class="btn-form">
                    Atualizar Perfil 
                    <i class="fa fa-retweet" aria-hidden="true"></i>
                </button>

             {!! Form::close() !!}

        </div><!--Row-->
    </section><!--Container-->

</div>

@endsection
