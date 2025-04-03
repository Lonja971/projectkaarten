<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TeacherApiKeyMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $api_key = $request->header('api_key') ?? $request->query('api_key');

        if (!$api_key) {
            return response()->json(['error' => 'Missing API Key'], 401);
        }

        $api_entry = ApiKey::where('api_key', $api_key)->first();
        if (!$api_entry) {
            return response()->json(['error' => 'Invalid API Key'], 401);
        }
        
        if (!User::isTeacher($api_entry->user_id)){
            return response()->json(['error' => 'Access is denied'], 403);
        }

        return $next($request);
    }
}
