<?php

namespace Nue\Lock\Http\Middleware;

use Nue\Lock\Lock as Extension;
use Illuminate\Http\Request;

class LockMiddleware
{
    protected $except = [
        'login',
        'logout',
        'lock',
        'unlock',
    ];

    public function handle(Request $request, \Closure $next)
    {
        if ( $this->shouldPassThrough($request) ) {
            return $next($request);
        }

        if ( $request->session()->has(Extension::LOCK_KEY) ) {
            return redirect()->route('nue-lock');
        }

        return $next($request);
    }

    protected function shouldPassThrough(Request $request)
    {
        foreach ($this->except as $except) {
            $except = trim(nue_base_path($except), '/');

            if ( $request->is($except) ) {
                return true;
            }
        }

        return false;
    }
}