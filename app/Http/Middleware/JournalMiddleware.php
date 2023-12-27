<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class JournalMiddleware
{
    public function handle($request, Closure $next)
    {
        $client = $request->route('client');

        if (!Gate::allows('update-client', $client)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
