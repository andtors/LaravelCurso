<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request){

        $credenciais = $request->all(['email', 'password']);

        $token = auth('api')->attempt($credenciais);

        if($token){
            return response()->json(['token' => $token]);
        } else {
            return response()->json(['erro' => "Usuario ou senha inválido!"], 403);
        }

        // 401 = Unauthorized -> não autorizado
        // 403 = Forbidden -> proibido

        return 'login';
    }

    public function logout(){
        auth('api')->logout();
        return response()->json(["msg" => "Logout realizado com sucesso!"]);
    }

    public function refresh(){
        return auth('api')->refresh(); // Cliente encaminhe um jwt valido
        return response()->json(['token' => $token]);
    }

    public function me(){
        return response()->json(auth()->user());
    }
}
