<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\ProjectStatus;
use App\Models\User;
use App\Models\Role;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $statuses = ProjectStatus::all();
        $roles = Role::all();
        
        $projects = [];
        $students = [];
        
        if ($user) {
            if ($user->role && $user->role->name === "Docent") {
                // Fetch all projects with student names for Docents
                $projects = DB::table('projects')
                    ->join('users', 'projects.user_id', '=', 'users.id')
                    ->leftJoin('project_statuses', 'projects.status_id', '=', 'project_statuses.id')
                    ->select('projects.*', 'users.full_name as user_name', 'project_statuses.name as status_name', 
                             'project_statuses.color', 'project_statuses.filled')
                    ->get();
                
                // Fetch all students for the students section
                $students = User::withCount('projects')
                    ->whereHas('role', function($query) {
                        $query->where('name', 'Student');
                    })
                    ->with('role')
                    ->get();
            } elseif ($user->role && $user->role->name === "Student") {
                // Fetch only user's projects for Students
                $projects = DB::table('projects')
                    ->where('projects.user_id', $user->id)
                    ->leftJoin('project_statuses', 'projects.status_id', '=', 'project_statuses.id')
                    ->select('projects.*', 'project_statuses.name as status_name', 
                             'project_statuses.color', 'project_statuses.filled')
                    ->get();
            }
        }
        
        return view('home', compact('user', 'projects', 'statuses', 'students', 'roles'));
    }
}
