@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header float-right">Tarefa</div>
                <div class="card-body">
                   <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Tarefa</th>
                                <th scope="col">Data Limite Conclusão</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($tarefas as $tarefa)
                            <tr>
                                <th>{{$tarefa->id}}</th>
                                <th>{{$tarefa->tarefa}}</th>
                                <th>{{date('d/m/Y', strtotime($tarefa->data_limite_conclusao))}}</th>
                                <th><a href="{{route('tarefa.edit', $tarefa->id)}}">Editar</a></th>
                                <th>
                                    <form id="form_{{$tarefa->id}}" method="POST" action="{{route('tarefa.destroy', ['tarefa' => $tarefa->id])}}">
                                    @method('DELETE')
                                    @csrf
                                    <a href="#" onclick="document.getElementById('form_{{$tarefa->id}}').submit()">Excluir</a>
                                    </form>
                                </th>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                   <nav>
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" href="{{$tarefas->previousPageUrl()}}">Voltar</a></li>
                            @for($i = 1; $i <= $tarefas->lastPage(); $i++)
                                <li class="page-item {{$tarefas->currentPage() == $i ? 'active' : ''}} ">
                                    <a class="page-link" href="{{$tarefas->url($i)}}">{{$i}}</a>
                                </li>
                            @endfor
                            <li class="page-item"><a class="page-link" href="{{$tarefas->nextPageUrl()}}">Avançar</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
