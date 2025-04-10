<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SprintController extends Controller
{
    public function show($user_identifier, $project_by_user_identifier, $sprint_week_nr = null)
    {
        return view('sprints.show', compact('user_identifier', 'project_by_user_identifier', 'sprint_nr'));
    }
}
