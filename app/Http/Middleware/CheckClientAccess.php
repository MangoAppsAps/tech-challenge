<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Client;




class CheckClientAccess
{

    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        $clients = Client::where('user_id', $user->id)->get();

        if ($clients->isEmpty()) {
            return redirect('/home')->with('error', 'You don\'t have any clients yet. Create a client to get started.');
        } else {
            return $next($request);
        }

    }
}
