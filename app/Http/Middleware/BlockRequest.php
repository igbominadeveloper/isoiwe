<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;

class BlockRequest
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
        if(! $request->user() || $request->user() == null){
            return response()->json([
                'errors' => 'Unauthorized Request'
            ], Response::HTTP_FORBIDDEN);
        }
        return $next($request);
    }
}
