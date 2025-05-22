<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Background;

class BackgroundController extends Controller
{
    /**
     * Return all background colors
     */
    public function index()
    {
        $backgrounds = Background::all();
        return ApiResponse::successWithoutMessage($backgrounds);
    }
}
