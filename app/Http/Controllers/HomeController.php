<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\ProjectStatus;
use App\Models\User;
use App\Models\Role;
use App\Models\Project;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $statuses = ProjectStatus::all();
        $roles = Role::all();
        $schoolyears = Project::getAllSchoolyears();
        
        // Initialize all student filter values with defaults first
        $studentFilters = [
            'sort' => 'name-asc', // Always set a default sort value
            'name' => '',
            'identifier' => ''
        ];
        
        // Initialize all project filter values with defaults first
        $projectFilters = [
            'sort' => 'creation-date-asc', // Default sort value
            'name' => ''
        ];
        
        // If no POST request (initial page load), add default filters
        if (!$request->isMethod('post')) {
            // Calculate current schoolyear for default filter
            $now = \Carbon\Carbon::now();
            $currentSchoolyearStart = $now->month >= 8 ? $now->year : $now->year - 1;
            $currentSchoolyear = $currentSchoolyearStart . '-' . ($currentSchoolyearStart + 1);
            
            // Set current schoolyear as default if it exists in available schoolyears
            if (in_array($currentSchoolyear, $schoolyears)) {
                $selectedSchoolyears = [$currentSchoolyear];
                $projectFilters['schoolyear-' . $currentSchoolyear] = true;
            }
            
            // Initialize status filters to all selected by default
            foreach ($statuses as $status) {
                $key = 'status-' . $status->id;
                $selectedStatuses[] = $status->id;
                $projectFilters[$key] = true;
            }
        }
        
        // Then override with any values from the request
        if ($request->isMethod('post')) {
            // Handle student filter form
            if ($request->has('identifier')) {
                if ($request->has('sort')) {
                    $studentFilters['sort'] = $request->input('sort');
                }
                
                if ($request->has('name')) {
                    $studentFilters['name'] = $request->input('name');
                }
                
                if ($request->has('identifier')) {
                    $studentFilters['identifier'] = $request->input('identifier');
                }
                
                // When student filter form is submitted, ensure all project statuses are selected by default
                $selectedStatuses = [];
                foreach ($statuses as $status) {
                    $key = 'status-' . $status->id;
                    $projectFilters[$key] = true;
                    $selectedStatuses[] = $status->id;
                }
            }
            // Handle project filter form
            else {
                if ($request->has('sort')) {
                    $projectFilters['sort'] = $request->input('sort');
                }
                
                if ($request->has('name')) {
                    $projectFilters['name'] = $request->input('name');
                }
                
                // Collect status filters (checkboxes)
                $selectedStatuses = [];
                foreach ($statuses as $status) {
                    $key = 'status-' . $status->id;
                    if ($request->has($key)) {
                        $selectedStatuses[] = $status->id;
                        $projectFilters[$key] = true;
                    }
                }
                
                // If no statuses were selected, select all of them automatically
                if (empty($selectedStatuses)) {
                    foreach ($statuses as $status) {
                        $key = 'status-' . $status->id;
                        $selectedStatuses[] = $status->id;
                        $projectFilters[$key] = true;
                    }
                }
                
                // Collect schoolyear filters (checkboxes)
                $selectedSchoolyears = [];
                foreach ($schoolyears as $schoolyear) {
                    $key = 'schoolyear-' . $schoolyear;
                    if ($request->has($key)) {
                        $selectedSchoolyears[] = $schoolyear;
                        $projectFilters[$key] = true;
                    }
                }
                
                // If no schoolyears were selected, select the current schoolyear by default
                if (empty($selectedSchoolyears)) {
                    // Calculate current schoolyear based on current date
                    $now = \Carbon\Carbon::now();
                    $currentSchoolyearStart = $now->month >= 8 ? $now->year : $now->year - 1;
                    $currentSchoolyear = $currentSchoolyearStart . '-' . ($currentSchoolyearStart + 1);
                    
                    // Add current schoolyear to selected ones if it exists in the available schoolyears
                    if (in_array($currentSchoolyear, $schoolyears)) {
                        $selectedSchoolyears[] = $currentSchoolyear;
                        $projectFilters['schoolyear-' . $currentSchoolyear] = true;
                    }
                }
                
                // If project filter form was submitted, ensure student filter has default sort
                $studentFilters['sort'] = 'name-asc';
            }
        }
        
        $projects = [];
        $students = [];
        
        if ($user) {
            if ($user->role && $user->role->name === "Docent") {
                // Start the project query
                $projectsQuery = DB::table('projects')
                    ->join('users', 'projects.user_id', '=', 'users.id')
                    ->leftJoin('project_statuses', 'projects.status_id', '=', 'project_statuses.id')
                    ->select('projects.*', 'users.full_name as user_name', 'project_statuses.name as status_name', 
                             'project_statuses.color', 'project_statuses.filled');
                
                // Apply project name filter if provided
                if (!empty($projectFilters['name'])) {
                    $projectsQuery->where('projects.title', 'like', '%' . $projectFilters['name'] . '%');
                }
                
                // Apply status filters
                if (!empty($selectedStatuses)) {
                    $projectsQuery->whereIn('projects.status_id', $selectedStatuses);
                }
                
                // Apply schoolyear filters
                if (!empty($selectedSchoolyears)) {
                    $projectsQuery->where(function($query) use ($selectedSchoolyears) {
                        foreach ($selectedSchoolyears as $schoolyear) {
                            // Parse the schoolyear into start and end years
                            list($startYear, $endYear) = explode('-', $schoolyear);

                            // A project spans this schoolyear if:
                            // 1. Project starts during this schoolyear, OR
                            // 2. Project ends during this schoolyear, OR
                            // 3. Project starts before this schoolyear AND ends after this schoolyear
                            $query->orWhere(function($q) use ($startYear, $endYear) {
                                // Case 1: Project starts during this schoolyear
                                // Start date is between August 1st of start year and July 31st of end year
                                $q->orWhere(function($subq) use ($startYear, $endYear) {
                                    $subq->where(function($dateq) use ($startYear) {
                                        // Start date is after or on August 1st of start year
                                        $dateq->where(DB::raw('YEAR(date_start)'), '=', $startYear)
                                              ->where(DB::raw('MONTH(date_start)'), '>=', 8);
                                    })
                                    ->orWhere(function($dateq) use ($startYear, $endYear) {
                                        // Start date is before August 1st of end year
                                        $dateq->where(DB::raw('YEAR(date_start)'), '=', $endYear)
                                              ->where(DB::raw('MONTH(date_start)'), '<', 8);
                                    });
                                });

                                // Case 2: Project ends during this schoolyear
                                // End date is between August 1st of start year and July 31st of end year
                                $q->orWhere(function($subq) use ($startYear, $endYear) {
                                    $subq->where(function($dateq) use ($startYear) {
                                        // End date is after or on August 1st of start year
                                        $dateq->where(DB::raw('YEAR(date_end)'), '=', $startYear)
                                              ->where(DB::raw('MONTH(date_end)'), '>=', 8);
                                    })
                                    ->orWhere(function($dateq) use ($startYear, $endYear) {
                                        // End date is before August 1st of end year
                                        $dateq->where(DB::raw('YEAR(date_end)'), '=', $endYear)
                                              ->where(DB::raw('MONTH(date_end)'), '<', 8);
                                    });
                                });

                                // Case 3: Project spans the entire schoolyear
                                // Start date is before or on August 1st of start year AND
                                // End date is after or on July 31st of end year
                                $q->orWhere(function($subq) use ($startYear, $endYear) {
                                    $subq->where(function($dateq) use ($startYear) {
                                        // Start date is before schoolyear start
                                        $dateq->where(DB::raw('YEAR(date_start)'), '<', $startYear)
                                              ->orWhere(function($d) use ($startYear) {
                                                  $d->where(DB::raw('YEAR(date_start)'), '=', $startYear)
                                                    ->where(DB::raw('MONTH(date_start)'), '<', 8);
                                              });
                                    })
                                    ->where(function($dateq) use ($endYear) {
                                        // End date is after schoolyear end
                                        $dateq->where(DB::raw('YEAR(date_end)'), '>', $endYear)
                                              ->orWhere(function($d) use ($endYear) {
                                                  $d->where(DB::raw('YEAR(date_end)'), '=', $endYear)
                                                    ->where(DB::raw('MONTH(date_end)'), '>=', 8);
                                              });
                                    });
                                });
                            });
                        }
                    });
                }
                
                // Apply project sorting
                switch ($projectFilters['sort']) {
                    case 'creation-date-asc':
                        $projectsQuery->orderBy('projects.created_at', 'desc'); // Newer first
                        break;
                    case 'creation-date-desc':
                        $projectsQuery->orderBy('projects.created_at', 'asc'); // Older first
                        break;
                    case 'update-date-asc':
                        $projectsQuery->orderBy('projects.updated_at', 'desc'); // Newer first
                        break;
                    case 'update-date-desc':
                        $projectsQuery->orderBy('projects.updated_at', 'asc'); // Older first
                        break;
                    case 'end-date-asc':
                        $projectsQuery->orderBy('projects.date_end', 'asc'); // Next end dates first
                        break;
                    case 'end-date-desc':
                        $projectsQuery->orderBy('projects.date_end', 'desc'); // Latest end dates first
                        break;
                    case 'name-asc':
                        $projectsQuery->orderBy('projects.title', 'asc'); // A-Z
                        break;
                    case 'name-desc':
                        $projectsQuery->orderBy('projects.title', 'desc'); // Z-A
                        break;
                    default:
                        $projectsQuery->orderBy('projects.created_at', 'desc'); // Default: newest first
                }
                
                $projects = $projectsQuery->get();
                
                // Fetch all students for the students section
                $studentsQuery = User::withCount('projects')
                    ->whereHas('role', function($query) {
                        $query->where('name', 'Student');
                    })
                    ->with('role');
                
                // Apply name filter if provided
                if (!empty($studentFilters['name'])) {
                    $studentsQuery->where('full_name', 'like', '%' . $studentFilters['name'] . '%');
                }
                
                // Apply identifier filter if provided
                if (!empty($studentFilters['identifier'])) {
                    $studentsQuery->where('identifier', 'like', '%' . $studentFilters['identifier'] . '%');
                }
                
                // Apply sorting
                switch ($studentFilters['sort']) {
                    case 'name-asc':
                        $studentsQuery->orderBy('full_name', 'asc');
                        break;
                    case 'name-desc':
                        $studentsQuery->orderBy('full_name', 'desc');
                        break;
                    case 'projects-desc':
                        $studentsQuery->orderBy('projects_count', 'desc');
                        break;
                    case 'projects-asc':
                        $studentsQuery->orderBy('projects_count', 'asc');
                        break;
                    default:
                        $studentsQuery->orderBy('full_name', 'asc');
                }
                
                $students = $studentsQuery->get();
            } elseif ($user->role && $user->role->name === "Student") {
                // Make sure all status filters are selected by default for students
                if (empty($selectedStatuses)) {
                    $selectedStatuses = [];
                    foreach ($statuses as $status) {
                        $key = 'status-' . $status->id;
                        $projectFilters[$key] = true;
                        $selectedStatuses[] = $status->id;
                    }
                }
                
                // If no schoolyears were selected, select the current schoolyear by default for students too
                if (empty($selectedSchoolyears)) {
                    // Calculate current schoolyear based on current date
                    $now = \Carbon\Carbon::now();
                    $currentSchoolyearStart = $now->month >= 8 ? $now->year : $now->year - 1;
                    $currentSchoolyear = $currentSchoolyearStart . '-' . ($currentSchoolyearStart + 1);
                    
                    // Add current schoolyear to selected ones if it exists in the available schoolyears
                    if (in_array($currentSchoolyear, $schoolyears)) {
                        $selectedSchoolyears[] = $currentSchoolyear;
                        $projectFilters['schoolyear-' . $currentSchoolyear] = true;
                    }
                }
                
                // Start the project query for Students
                $projectsQuery = DB::table('projects')
                    ->where('projects.user_id', $user->id)
                    ->leftJoin('project_statuses', 'projects.status_id', '=', 'project_statuses.id')
                    ->select('projects.*', 'project_statuses.name as status_name', 
                            'project_statuses.color', 'project_statuses.filled');
                
                // Apply project name filter if provided
                if (!empty($projectFilters['name'])) {
                    $projectsQuery->where('projects.title', 'like', '%' . $projectFilters['name'] . '%');
                }
                
                // Apply status filters
                if (!empty($selectedStatuses)) {
                    $projectsQuery->whereIn('projects.status_id', $selectedStatuses);
                }
                
                // Apply schoolyear filters
                if (!empty($selectedSchoolyears)) {
                    $projectsQuery->where(function($query) use ($selectedSchoolyears) {
                        foreach ($selectedSchoolyears as $schoolyear) {
                            // Parse the schoolyear into start and end years
                            list($startYear, $endYear) = explode('-', $schoolyear);

                            // A project spans this schoolyear if:
                            // 1. Project starts during this schoolyear, OR
                            // 2. Project ends during this schoolyear, OR
                            // 3. Project starts before this schoolyear AND ends after this schoolyear
                            $query->orWhere(function($q) use ($startYear, $endYear) {
                                // Case 1: Project starts during this schoolyear
                                // Start date is between August 1st of start year and July 31st of end year
                                $q->orWhere(function($subq) use ($startYear, $endYear) {
                                    $subq->where(function($dateq) use ($startYear) {
                                        // Start date is after or on August 1st of start year
                                        $dateq->where(DB::raw('YEAR(date_start)'), '=', $startYear)
                                              ->where(DB::raw('MONTH(date_start)'), '>=', 8);
                                    })
                                    ->orWhere(function($dateq) use ($startYear, $endYear) {
                                        // Start date is before August 1st of end year
                                        $dateq->where(DB::raw('YEAR(date_start)'), '=', $endYear)
                                              ->where(DB::raw('MONTH(date_start)'), '<', 8);
                                    });
                                });

                                // Case 2: Project ends during this schoolyear
                                // End date is between August 1st of start year and July 31st of end year
                                $q->orWhere(function($subq) use ($startYear, $endYear) {
                                    $subq->where(function($dateq) use ($startYear) {
                                        // End date is after or on August 1st of start year
                                        $dateq->where(DB::raw('YEAR(date_end)'), '=', $startYear)
                                              ->where(DB::raw('MONTH(date_end)'), '>=', 8);
                                    })
                                    ->orWhere(function($dateq) use ($startYear, $endYear) {
                                        // End date is before August 1st of end year
                                        $dateq->where(DB::raw('YEAR(date_end)'), '=', $endYear)
                                              ->where(DB::raw('MONTH(date_end)'), '<', 8);
                                    });
                                });

                                // Case 3: Project spans the entire schoolyear
                                // Start date is before or on August 1st of start year AND
                                // End date is after or on July 31st of end year
                                $q->orWhere(function($subq) use ($startYear, $endYear) {
                                    $subq->where(function($dateq) use ($startYear) {
                                        // Start date is before schoolyear start
                                        $dateq->where(DB::raw('YEAR(date_start)'), '<', $startYear)
                                              ->orWhere(function($d) use ($startYear) {
                                                  $d->where(DB::raw('YEAR(date_start)'), '=', $startYear)
                                                    ->where(DB::raw('MONTH(date_start)'), '<', 8);
                                              });
                                    })
                                    ->where(function($dateq) use ($endYear) {
                                        // End date is after schoolyear end
                                        $dateq->where(DB::raw('YEAR(date_end)'), '>', $endYear)
                                              ->orWhere(function($d) use ($endYear) {
                                                  $d->where(DB::raw('YEAR(date_end)'), '=', $endYear)
                                                    ->where(DB::raw('MONTH(date_end)'), '>=', 8);
                                              });
                                    });
                                });
                            });
                        }
                    });
                }
                
                // Apply project sorting
                switch ($projectFilters['sort']) {
                    case 'creation-date-asc':
                        $projectsQuery->orderBy('projects.created_at', 'desc'); // Newer first
                        break;
                    case 'creation-date-desc':
                        $projectsQuery->orderBy('projects.created_at', 'asc'); // Older first
                        break;
                    case 'update-date-asc':
                        $projectsQuery->orderBy('projects.updated_at', 'desc'); // Newer first
                        break;
                    case 'update-date-desc':
                        $projectsQuery->orderBy('projects.updated_at', 'asc'); // Older first
                        break;
                    case 'end-date-asc':
                        $projectsQuery->orderBy('projects.date_end', 'asc'); // Next end dates first
                        break;
                    case 'end-date-desc':
                        $projectsQuery->orderBy('projects.date_end', 'desc'); // Latest end dates first
                        break;
                    case 'name-asc':
                        $projectsQuery->orderBy('projects.title', 'asc'); // A-Z
                        break;
                    case 'name-desc':
                        $projectsQuery->orderBy('projects.title', 'desc'); // Z-A
                        break;
                    default:
                        $projectsQuery->orderBy('projects.created_at', 'desc'); // Default: newest first
                }
                
                $projects = $projectsQuery->get();
            }
        }
        
        return view('home', compact('user', 'projects', 'statuses', 'students', 'roles', 'schoolyears', 'studentFilters', 'projectFilters'));
    }
}
