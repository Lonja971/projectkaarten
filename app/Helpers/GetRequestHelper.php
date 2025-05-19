<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class GetRequestHelper
{
    /**
     * Get value from header, query or body
     */
    public function extractValue(Request $request, string $key): ?string
    {
        return $request->header($key)
            ?? $request->query($key)
            ?? $request->input($key);
    }
}
