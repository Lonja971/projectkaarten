<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SprintController extends Controller
{
    public function show($user_nr, $project_by_user_nr, $sprint_week_nr = null)
    {
        return view('sprints.show', compact('user_nr', 'project_by_user_nr', 'sprint_week_nr'));
    }
}
