<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class LoginController extends Controller
{
    //
    public function index(Request $request){

        $erro = '';

        if($request->get('erro') == 1){
            $erro = 'Usuário ou senha não existem.';
        } else if ($request->get('erro') == 2){
            $erro = 'Necessario fazer login para acessar a pagina';
        }

        return view('site.login', ['titulo' => "Login", 'erro' => $erro]);
    }

    public function autenticar(Request $request){

        // regras de validação
        $regras = [
            'usuario' => 'email',
            'senha' => 'required'
        ];

        // as mensagems de feedback de validação
        $feedback = [
            'usuario.email'=> 'O campo usuário (e-mail) é obrigatorio.',
            'senha.required' => 'O campo senha é obrigatorio'
        ];

        // se não passar pelo validate
        $request->validate($regras, $feedback);

        $email = $request->get('usuario');
        $password = $request->get('senha');

        // iniciar model user
        $user = new User();

        $usuario = $user->where('email', $email)
                        ->where('password', $password)
                        ->get()
                        ->first();

        if(isset($usuario->name)){
            session_start();
            $_SESSION['nome'] = $usuario->name;
            $_SESSION['email'] = $usuario->email;

            return redirect()->route('app.home');
        } else {
           return redirect()->route('site.login', ['erro' => 1]);
        }
       
    }

    public function sair(){
            session_destroy();
            return redirect()->route('site.index');
    }
}
