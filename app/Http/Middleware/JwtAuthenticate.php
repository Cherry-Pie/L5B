<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Http\Middleware\Authenticate;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class JwtAuthenticate extends Authenticate
{
    use ApiResponseTrait;
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @throws \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $this->authenticate($request);
        } catch (UnauthorizedHttpException $e) {
            return $this->fail($e->getMessage(), 401);
        }
        

        return $next($request);
    }
}
