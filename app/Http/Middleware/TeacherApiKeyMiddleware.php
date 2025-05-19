<?php

namespace App\Http\Middleware;

use App\Helpers\ApiResponse;
use App\Models\ApiKey;
use App\Models\User;
use App\Helpers\GetRequestHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TeacherApiKeyMiddleware
{
    protected GetRequestHelper $apiKeyService;

    public function __construct(GetRequestHelper $apiKeyService)
    {
        $this->apiKeyService = $apiKeyService;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $api_key = $this->apiKeyService->extractValue($request, "api_key");

        if (!$api_key || !$this->isValidTeacherKey($api_key)) {
            return ApiResponse::accessDenied();
        }

        return $next($request);
    }

    private function isValidTeacherKey(string $api_key): bool
    {
        $api_entry = ApiKey::where('api_key', $api_key)->first();

        if (!$api_entry) {
            return false;
        }

        return User::isTeacher($api_entry->user_id);
    }
}
