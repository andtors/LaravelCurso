<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\LogAcesso;

class LogAcessoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // $request manipular
        $ip = $request->server->get('REMOTE_ADDR');
        $rota = $request->getRequestUri();
        $method = $request->getMethod();

        //dd($request);
        // $response manipular
        LogAcesso::create(['log' => "IP: $ip requisitou a rota $rota e metodo: $method"]);
        //return $next($request);

        $reposta = $next($request);

        $reposta->setStatusCode(201, 'O status da resposta e 201');
   
        return $reposta;
    }   
}
