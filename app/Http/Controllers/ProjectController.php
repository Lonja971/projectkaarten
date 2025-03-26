<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function index($user_identifier)
    {
        return view('projects.index', compact('user_identifier'));
    }

    public function show($user_identifier, $project_by_user_identifier = null)
    {
        //$user_id = Auth::id(); - get current user id

        return view('projects.show', compact('user_identifier', 'project_by_user_identifier'));
    }
}
