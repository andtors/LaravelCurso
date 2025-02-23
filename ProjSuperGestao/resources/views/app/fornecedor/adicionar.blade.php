@extends('app.layouts.basico')

@section('titulo', 'Fornecedor')

@section('conteudo')
    <div class="conteudo-pagina">
        <div class="titulo-pagina-2">
            <p>Fornecedor - Adicionar</p>
        </div>

        <div class="menu">
            <ul>
                <li> <a href="{{route('app.fornecedor')}}"> Consulta </a></li>
            </ul>
        </div>
        {{ isset($msg) ?  $msg : "" }}
        <div class="informacao-pagina">
            <div style="width:30%; margin-left:auto; margin-right:auto;">
                    <form method="POST" action="{{route('app.fornecedor.adicionar')}}">
                        @csrf
                        <input type="hidden" name="id" value="{{$fornecedor->id ?? null}}">
                        <input type="text" name="nome" value="{{ $fornecedor->nome ?? old('nome')}}" placeholder="Nome" class="borda-preta">
                        {{ $errors->has('nome') ? $errors->first('nome') : "" }}
                        <input type="text" name="site" value="{{ $fornecedor->site ?? old('site')}}" placeholder="Site" class="borda-preta">
                        {{ $errors->has('site') ? $errors->first('site') : "" }}
                        <input type="text" name="uf" value="{{ $fornecedor->uf ?? old('uf')}}" placeholder="UF" class="borda-preta">
                        {{ $errors->has('uf') ? $errors->first('uf') : "" }}
                        <input type="text" name="email" value="{{ $fornecedor->email ?? old('email')}}" placeholder="E-mail" class="borda-preta">
                        {{ $errors->has('email') ? $errors->first('email') : "" }}
                        @if(isset($fornecedor))
                        <button type="submit" class="borda-preta">Atualizar</button>
                        @else
                        <button type="submit" class="borda-preta">Adicionar</button>
                        @endif
                </form>
            </div>
        </div>
    </div>
@endsection