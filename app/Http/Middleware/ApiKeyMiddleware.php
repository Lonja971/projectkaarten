<?php

namespace App\Http\Middleware;

use App\Helpers\ApiResponse;
use App\Helpers\GetRequestHelper;
use App\Models\ApiKey;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    protected GetRequestHelper $apiKeyService;

    public function __construct(GetRequestHelper $apiKeyService)
    {
        $this->apiKeyService = $apiKeyService;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $api_key = $api_key = $this->apiKeyService->extractValue($request, "api_key");

        if (!$api_key || !ApiKey::isValid($api_key)) {
            return ApiResponse::accessDenied();
        }

        return $next($request);
    }
}
