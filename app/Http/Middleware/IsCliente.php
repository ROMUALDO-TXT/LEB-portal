<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsCliente
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
        // Verificar se o usuário está autenticado
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Verificar se o usuário tem a propriedade "role" definida como "Cliente"
        if ($request->user()->role === 'Cliente') {
            return $next($request);
        }

        // Caso o usuário não seja um administrador, redirecionar para uma rota ou retornar um erro
        return redirect()->route('home')->with('error', 'Acesso negado. Somente clientes têm permissão para acessar esta página.');
    }
}