@extends('site.template.app')

@section('content-site')

<div class="content">

    <section class="container">
        <h1 class="title">Minhas Compras</h1>
        
        <div class="messages">
            @include('panel.includes.alerts')
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th width="80px" class="text-center">Cod</th>
                    <th>Vôo</th>
                    <th class="text-center">Data</th>
                    <th width="120px" class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($purchases as $reserve)
                <tr>
                    <td class="text-center">{{ $reserve->id }}</td>
                    <td>
                        <a href="{{ route('site.purchase.detail', $reserve->id) }}" class="badge badge-info" 
                            style="font-size: 14px">
                            Ver Detalhes do Vôo: {{ $reserve->flight->id }} 
                            <i class="fas fa-info-circle"></i>
                        </a>
                    </td>
                    <td class="text-center">{{ formatDateAndTime($reserve->date_reserved) }}</td>
                    <td class="text-center">
                        <span class="badge badge-primary" style="font-size: 14px">
                            {{ $reserve->getStatus($reserve->status) }}
                        </span>
                    </td>
                </tr>
               @empty
               <tr>
                   <td colspan="4" style="text-align: center;">
                       Você ainda não fez nenhuma compra! Faça <a href="{{ route('site.promotions') }}">agora</a>!
                       Veja nossas <a href="{{ route('site.promotions') }}">promoções</a>!
                   </td>
               </tr>
               @endforelse
            </tbody>
        </table>
    </section><!--Container-->

</div>

@endsection
