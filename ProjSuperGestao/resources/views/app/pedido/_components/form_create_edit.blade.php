@if(isset($pedido->id))
    <form method="POST" action="{{route('pedido.update', ['pedido'=> $pedido->id])}}">
    @method('PUT')
@else
    <form method="POST" action="{{route('pedido.store')}}">
@endif
        @csrf
        <input type="hidden" name="id" value="{{ $pedido->id ?? ''}}">
        <select name="cliente_id">
            <option>Selecione um Fornecedor</option>
            @foreach($clientes as $cliente)
            <option value="{{$cliente->id}}" {{$pedido->cliente_id ?? old('cliente_id') == $cliente->id ? 'selected' : ''}} >{{$cliente->nome}}</option>
            @endforeach
        </select>
        {{ $errors->has('cliente_id') ? $errors->first('cliente_id') : ''}}
        @if(isset($pedido->id))
            <button type="submit" class="borda-preta">Editar</button>
        @else 
            <button type="submit" class="borda-preta">Cadastrar</button>
        @endif
    </form>