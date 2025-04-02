<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $api_key = $request->header('api_key') ?? $request->query('api_key');

        if (!$api_key || !ApiKey::isValid($api_key)) {
            return response()->json(['error' => 'Invalid or missing API Key'], 401);
        }

        return $next($request);
    }
}
