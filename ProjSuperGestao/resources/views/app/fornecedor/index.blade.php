<h3>Fornecedor</h3>

@php



@endphp
{{--
@if(count($fornecedores) > 0 && count($fornecedores) < 10)
    <h3> Existem alguns fornecedores cadastrados </h3>
@elseif(count($fornecedores) > 10)
    <h3> Existem varios fornecedores cadastrados </h3>
@else
    <h3> Ainda não existem fornecedores cadastrados </h3>
@endif

@unless($fornecedores[0]['status'] == 'S')
    Inativo
@endunless
<br>
@unless($fornecedores[0]['status'] == 'N')
    <h3> Ativo </h3>
@endunless


@foreach($fornecedores as $fornecedor)
    @isset($fornecedor)
        Fornecedor: {{ $fornecedor['nome'] }}
        <br>
        Status: {{ $fornecedor['status']}}
        <br>
        CNPJ: {{$fornecedor['cnpj'] ?? 'Dado não preenchido'}}
        <br>
    @endisset
@endforeach

--}}

@isset($fornecedores)
    @forelse($fornecedores as $fornecedor)
            Iteração atual: {{ $loop->iteration }}
            <br>
            Fornecedor: {{ $fornecedor['nome']}}
            <br>
            Status: {{ $fornecedor['status']}}
            <br>
            CNPJ: {{$fornecedor['cnpj'] ?? 'Dado não preenchido'}}
            <br>
            Telefone: ({{$fornecedor['ddd'] ?? '' }}) {{$fornecedor['telefone'] ?? ''}}
            <br>
            @if($loop->first)
                Primeira iteração do loop
            @endif
            @if($loop->last)
                Ultima iteração do loop

                <br>

                Total de registro: {{$loop->count}}
            @endif
            <hr>
        @empty
         Não existem forncedores cadastrados
    @endforelse      
@endisset

<br>




