<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X-API-KEY'); // ambil header
        $validKey = env('API_KEY'); // simpan kunci rahasia di .env

        if ($apiKey !== $validKey) {
            return response()->json(['message' => 'Invalid Key'], 401);
        }

        return $next($request);
    }
}
