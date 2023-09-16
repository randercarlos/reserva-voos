@extends('site.template.app')


@section('content-site')

<div class="content text-center">
    <img src="{{ asset('assets/site/images/error-404.png') }}" alt="404">
    
    <h5>Página não encontrada! Tente novamente dentro de alguns instantes! <br /> <br /><br />
    Se o erro persistir, contate o setor de informática!</h5>
</div>


@endsection