@if(isset($cliente->id))
    <form method="POST" action="{{route('cliente.update', ['cliente'=> $cliente->id])}}">
    @method('PUT')
@else
    <form method="POST" action="{{route('cliente.store')}}">
@endif
        @csrf
        <input type="hidden" name="id" value="{{ $cliente->id ?? ''}}">
        <input type="text" name="nome" value="{{ $cliente->nome ?? old('nome') }}" placeholder="Nome" class="borda-preta">
        {{ $errors->has('nome') ? $errors->first('nome') : ''}}
        @if(isset($cliente->id))
            <button type="submit" class="borda-preta">Editar</button>
        @else 
            <button type="submit" class="borda-preta">Cadastrar</button>
        @endif
    </form>