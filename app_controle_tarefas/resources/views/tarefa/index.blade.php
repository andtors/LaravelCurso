@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tarefas</div>

                <div class="card-body">
                   <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Tarefa</th>
                                <th scope="col">Data Conclusão</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($tarefas as $tarefa)
                            <tr>
                                <th>{{$tarefa->id}}</th>
                                <th>{{$tarefa->tarefa}}</th>
                                <th>{{date('d/m/Y', strtotime($tarefa->data_limite_conclusao))}}</th>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
