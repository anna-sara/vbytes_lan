<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         if ($request->header('X-API-KEY') === config('apikeys.key_1')) {

            $request->merge(["permission" => "key_1"]);

        } elseif ($request->header('X-API-KEY') === config('apikeys.key_2')) {

               $request->merge(["permission" => "key_2"]);

        } elseif ($request->header('X-API-KEY') === config('apikeys.key_3')) {

               $request->merge(["permission" => "key_3"]);

        } elseif ($request->header('X-API-KEY') === config('apikeys.key_4')) {

               $request->merge(["permission" => "key_4"]);

        } else {
           return response()->json(['code' => 401, 'message' => 'Unauthorized']);
        }
         return $next($request);
    }
}
