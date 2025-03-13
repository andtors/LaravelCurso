Site da aplicação

@auth
    <h1>Usuario autenticado</h1>
    <p>ID: {{Auth::user()->id}}</p>
    <p>Nome: {{Auth::user()->name}}</p>
    <p>E-mail: {{Auth::user()->email}}</p>
@endauth

@guest
    <h1>Olá visitante tudo bem!</h1>
    <a href="{{ route('login') }}""> Login </a>
@endguest