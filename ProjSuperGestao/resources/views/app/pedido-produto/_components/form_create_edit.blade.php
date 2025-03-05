    <form method="POST" action="{{route('pedido-produto.store', ['pedido' => $pedido->id])}}">
        @csrf
        <input type="hidden" name="id" value="{{ $pedido->id ?? ''}}">
        <select name="produto_id">
            <option>Selecione um Produto</option>
            @foreach($produtos as $produto)
            <option value="{{$produto->id}}" {{$pedido->produto_id ?? old('produto_id') == $produto->id ? 'selected' : ''}} >{{$produto->nome}}</option>
            @endforeach
        </select>
        {{ $errors->has('produto_id') ? $errors->first('produto_id') : ''}}

        <input type="number" name="quantidade" value="{{old('quantidade') ? old('quantidade') : ''}}"
         placeholder="Quantidade" class="borda-preta" />
          {{ $errors->has('quantidade') ? $errors->first('quantidade') : ''}}

        @if(isset($pedido->id))
            <button type="submit" class="borda-preta">Editar</button>
        @else 
            <button type="submit" class="borda-preta">Cadastrar</button>
        @endif
    </form>