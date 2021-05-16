<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AddHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        if(session('token')){
            $response->header('Authorization', 'Bearer '.session('token'));
        }
        // $response->header('another header', 'another value');

        return $response;
    }
}
