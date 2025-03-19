<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function index($user_nr)
    {
        return view('projects.index', compact('user_nr'));
    }

    public function show($user_nr, $project_by_user_nr = null)
    {
        //$user_id = Auth::id(); - get current user id

        return view('projects.show', compact('user_nr', 'project_by_user_nr'));
    }
}
