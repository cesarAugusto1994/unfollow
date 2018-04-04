<?php

namespace App\Http\Middleware;

use Closure;

class CheckAccessToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->user()->configurations->access_token) {
           #flash("<strong>Atenção</strong>, Para iniciar é necessário adicionar o APP_ID para acessar a aplicação.")->warning()->important();
           return redirect()->route('redirect_auth');
        }

        return $next($request);
    }
}
