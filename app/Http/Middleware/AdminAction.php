<?php

namespace App\Http\Middleware;

use App\Facades\Verfication;
use Closure;

class AdminAction
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
        try {
            Verfication::admin(AdminAction::class);
        } catch (\Exception $e) {
            return response($e->getMessage());
        }

        return $next($request);
    }
}
