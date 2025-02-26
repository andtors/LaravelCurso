@extends('app.layouts.basico')

@section('titulo', 'Fornecedor')

@section('conteudo')
    <div class="conteudo-pagina">
        <div class="titulo-pagina-2">
            <p>Produto - Adicionar</p>
        </div>

        <div class="menu">
            <ul>
                <li><a href="{{route('produto.index')}}">  Consulta </a></li>
            </ul>
        </div>
            
            <div class="informacao-pagina">
            <div style="width:30%; margin-left:auto; margin-right:auto;">
                    <form method="POST" action="">
                        @csrf
                        <input type="hidden" name="id" value="">
                        <input type="text" name="nome" value="" placeholder="Nome" class="borda-preta">
                        <input type="text" name="descricao" value="" placeholder="Descrição" class="borda-preta">
                        <input type="text" name="peso" value="" placeholder="Peso" class="borda-preta">
                        <select name="unidade_id">
                            <option>Selecione a unidade de medida</option>
                            @foreach($unidades as $unidade)
                            <option value="{{$unidade->id}}">{{$unidade->descricao}}</option>
                            @endforeach
                        </select>               
                        <button type="submit" class="borda-preta">Cadastrar</button>
                        
                </form>
            </div>
        </div>
    </div>
@endsection