<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Icon;

class IconController extends Controller
{
    /**
     * Return all icons
     */
    public function index()
    {
        $icons = Icon::all();
        return ApiResponse::successWithoutMessage($icons);
    }
}
