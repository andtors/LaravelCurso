<x-mail::message>
# Introduction

Corpo da mensagem.

- Opção 1
- Opção 2
- Opção 3

<x-mail::button :url="''">
Texto do botão 1
</x-mail::button>

<x-mail::button :url="''">
Texto do botão 2
</x-mail::button>

Obrigado,<br>
{{ config('app.name') }}
</x-mail::message>
