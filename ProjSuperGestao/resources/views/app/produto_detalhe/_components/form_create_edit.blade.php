@if(isset($produto_detalhe->id))
    <form method="POST" action="{{route('produto-detalhe.update', ['produto_detalhe' => $produto_detalhe])}}">
    @method('PUT')
@else
    <form method="POST" action="{{route('produto-detalhe.store')}}">
@endif
        @csrf
        <input type="hidden" name="id" value="{{ $produto_detalhe->id ?? ''}}">
        <select name="fornecedor_id">
            <option>Selecione um Fornecedor</option>
            @foreach($fornecedores as $fornecedor)
            <option value="{{$fornecedor->id}}" {{$produto->fornecedor_id ?? old('fornecedor_id') == $fornecedor->id ? 'selected' : ''}} >{{$fornecedor->nome}}</option>
            @endforeach
        </select>    
        {{ $errors->has('fornecedor_id') ? $errors->first('fornecedor_id') : ''}}
        <input type="text" name="produto_id" value="{{ $produto_detalhe->produto_id ?? old('produto_id') }}" placeholder="ID do Produto" class="borda-preta">
        {{ $errors->has('produto_id') ? $errors->first('produto_id') : ''}}
        <input type="text" name="comprimento" value="{{ $produto_detalhe->comprimento ?? old('comprimento')}}" placeholder="Comprimento do Produto" class="borda-preta">
        {{ $errors->has('comprimento') ? $errors->first('comprimento') : ''}}
        <input type="text" name="largura" value="{{ $produto_detalhe->largura ?? old('largura') }}" placeholder="Largura do Produto" class="borda-preta">
        {{ $errors->has('largura') ? $errors->first('largura') : ''}}
        <input type="text" name="altura" value="{{ $produto_detalhe->altura ?? old('altura') }}" placeholder="Altura do Produto" class="borda-preta">
        {{ $errors->has('altura') ? $errors->first('altura') : ''}}
        <select name="unidade_id">
            <option>Selecione a unidade de medida</option>
            @foreach($unidades as $unidade)
            <option value="{{$unidade->id}}" {{$produto_detalhe->unidade_id ?? old('unidade_id') == $unidade->id ? 'selected' : ''}} >{{$unidade->descricao}}</option>
            @endforeach
        </select>               
        {{ $errors->has('unidade_id') ? $errors->first('unidade_id') : ''}}
        @if(isset($produto_detalhe->id))
            <button type="submit" class="borda-preta">Editar</button>
        @else 
            <button type="submit" class="borda-preta">Cadastrar</button>
        @endif
    </form>