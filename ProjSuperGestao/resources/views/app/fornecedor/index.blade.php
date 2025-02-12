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
--}}

@isset($fornecedores)

    Fornecedor: {{ $fornecedores[0]['nome']}}
    <br>
    Status: {{ $fornecedores[0]['status']}}
    <br>
    @isset($fornecedores[0]['cnpj'])
        CNPJ: {{ $fornecedores[0]['cnpj']}}
    @endisset

@endisset

