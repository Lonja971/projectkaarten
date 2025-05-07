<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Icon;
use App\Models\Background;
use App\Models\ProjectStatus;
use App\Models\User;
use Carbon\Carbon;

class Project extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    protected $attributes = [
        'status_id' => 1,
        'icon_id' => 1,
        'background_id' => 38,
    ];

    protected $casts = [
        'user_id' => 'integer',
        'icon_id' => 'integer',
        'background_id' => 'integer',
    ];
    
    public function status()
    {
        return $this->belongsTo(ProjectStatus::class);
    }

    public function sprints()
    {
        return $this->hasMany(Sprint::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function icon()
    {
        return $this->belongsTo(Icon::class, 'icon_id');
    }
    
    public function background()
    {
        return $this->belongsTo(Background::class, 'background_id');
    }
    
    /**
     * Get the schoolyear for a given date
     * Dutch schoolyears run from August 1st to July 31st
     * 
     * @param string|Carbon $date The date to get the schoolyear for
     * @return string The schoolyear in format "YYYY-YYYY"
     */
    public static function getSchoolyearFromDate($date)
    {
        if (!$date instanceof Carbon) {
            $date = Carbon::parse($date);
        }
        
        // If the date is on or after August 1st, it belongs to the schoolyear that starts that year
        // Otherwise, it belongs to the schoolyear that started the previous year
        $year = $date->month >= 8 ? $date->year : $date->year - 1;
        
        return $year . '-' . ($year + 1);
    }
    
    /**
     * Get the schoolyear for this project's end date (legacy method, kept for compatibility)
     * 
     * @return string The schoolyear in format "YYYY-YYYY"
     */
    public function getSchoolyear()
    {
        return self::getSchoolyearFromDate($this->date_end);
    }
    
    /**
     * Get all unique schoolyears from existing projects' date ranges
     * 
     * @return array Array of schoolyears in format "YYYY-YYYY", sorted descending
     */
    public static function getAllSchoolyears()
    {
        $projects = self::all();
        $schoolyears = [];
        
        foreach ($projects as $project) {
            // Get all schoolyears this project spans
            $projectSchoolyears = $project->getAllSpannedSchoolyears();
            $schoolyears = array_merge($schoolyears, $projectSchoolyears);
        }
        
        // Get unique schoolyears and sort them descending (newest first)
        $schoolyears = array_unique($schoolyears);
        rsort($schoolyears);
        
        return $schoolyears;
    }
    
    /**
     * Get all schoolyears this project spans (from start date to end date)
     * 
     * @return array Array of schoolyears in format "YYYY-YYYY"
     */
    public function getAllSpannedSchoolyears()
    {
        if (!$this->date_start || !$this->date_end) {
            // If missing dates, just return current schoolyear
            return [self::getSchoolyearFromDate(Carbon::now())];
        }
        
        $startDate = Carbon::parse($this->date_start);
        $endDate = Carbon::parse($this->date_end);
        
        // Get schoolyear for start and end dates
        $startSchoolyear = self::getSchoolyearFromDate($startDate);
        $endSchoolyear = self::getSchoolyearFromDate($endDate);
        
        // If start and end are in the same schoolyear, return just that one
        if ($startSchoolyear === $endSchoolyear) {
            return [$startSchoolyear];
        }
        
        // Otherwise, we need to get all schoolyears in between
        $startYear = (int)explode('-', $startSchoolyear)[0];
        $endYear = (int)explode('-', $endSchoolyear)[0];
        
        $schoolyears = [];
        for ($year = $startYear; $year <= $endYear; $year++) {
            $schoolyears[] = $year . '-' . ($year + 1);
        }
        
        return $schoolyears;
    }

    public static function getUserIdByProjectId(int $project_id)
    {
        return Project::where('id', $project_id)->value('user_id');
    }

    /**
     * Check if a user has access to a specific project.
     *
     * @param int $userId The ID of the user.
     * @param int $projectId The ID of the project.
     * @return bool True if the user has access, false otherwise.
     */
    public static function userHasAccess(int $user_id, int $project_id): bool
    {
        if (User::isTeacher($user_id)) return true;
        
        return Project::getUserIdByProjectId($project_id) === $user_id;
    }
}
