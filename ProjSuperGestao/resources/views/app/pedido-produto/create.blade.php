@extends('app.layouts.basico')

@section('titulo', 'Pedido')

@section('conteudo')
    <div class="conteudo-pagina">
        <div class="titulo-pagina-2">
                <p>Adicionar Produtos ao Pedido</p>
        </div>

        <div class="menu">
            <ul>
                <li><a href="{{route('pedido.index')}}">  Voltar </a></li>
            </ul>
        </div>
            
        <div class="informacao-pagina">
            <h4> Detalhes do pedido </h4>
            <p> ID do pedido: {{$pedido->id}}</p>
            <p> Cliente: {{$pedido->cliente_id}}</p>
        </div>
        <div style="width:30%; margin-left:auto; margin-right:auto;">
            <h4> Itens do pedido </h4>
            {{$pedido}}
            @component('app.pedido-produto._components.form_create_edit', ['pedido' => $pedido, 'produtos' => $produtos])
            @endcomponent
        </div>
    </div>
@endsection