@if(isset($produto->id))
    <form method="POST" action="{{route('produto.update', ['produto'=> $produto->id])}}">
    @method('PUT')
@else
    <form method="POST" action="{{route('produto.store')}}">
@endif
        @csrf
        <input type="hidden" name="id" value="{{ $produto->id ?? ''}}">
        <select name="fornecedor_id">
            <option>Selecione um Fornecedor</option>
            @foreach($fornecedores as $fornecedor)
            <option value="{{$fornecedor->id}}" {{$produto->fornecedor_id ?? old('fornecedor_id') == $fornecedor->id ? 'selected' : ''}} >{{$fornecedor->nome}}</option>
            @endforeach
        </select>    
        {{ $errors->has('fornecedor_id') ? $errors->first('fornecedor_id') : ''}}
        <input type="text" name="nome" value="{{ $produto->nome ?? old('nome') }}" placeholder="Nome" class="borda-preta">
        {{ $errors->has('nome') ? $errors->first('nome') : ''}}
        <input type="text" name="descricao" value="{{ $produto->descricao ?? old('descricao')}}" placeholder="Descrição" class="borda-preta">
        {{ $errors->has('descricao') ? $errors->first('descricao') : ''}}
        <input type="text" name="peso" value="{{ $produto->peso ?? old('peso') }}" placeholder="Peso" class="borda-preta">
        {{ $errors->has('peso') ? $errors->first('peso') : ''}}
        <select name="unidade_id">
            <option>Selecione a unidade de medida</option>
            @foreach($unidades as $unidade)
            <option value="{{$unidade->id}}" {{$produto->unidade_id ?? old('unidade_id') == $unidade->id ? 'selected' : ''}} >{{$unidade->descricao}}</option>
            @endforeach
        </select>               
        {{ $errors->has('unidade_id') ? $errors->first('unidade_id') : ''}}
        @if(isset($produto->id))
            <button type="submit" class="borda-preta">Editar</button>
        @else 
            <button type="submit" class="borda-preta">Cadastrar</button>
        @endif
    </form>