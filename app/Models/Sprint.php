<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sprint extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    protected $attributes = [
        'status_id' => 1,
    ];

    protected $casts = [
        'project_id' => 'integer',
    ];

    protected $fillable = [
        'sprint_nr',
        'project_id',
        'date_start',
        'date_end',
        'reflection',
        'feedback'
    ];

    public function status()
    {
        return $this->belongsTo(SprintStatus::class);
    }

    public function goals()
    {
        return $this->hasMany(SprintGoalAndRetrospective::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public static function isDateAvailableForProject($project_id, $date_start, $date_end)
    {
        return Sprint::where('project_id', $project_id)
            ->where(function ($query) use ($date_start, $date_end) {
                $query->whereBetween('date_start', [$date_start, $date_end])
                      ->orWhereBetween('date_end', [$date_start, $date_end])
                      ->orWhere(function ($q) use ($date_start, $date_end) {
                          $q->where('date_start', '<=', $date_start)
                            ->where('date_end', '>=', $date_end);
                      });
            })
            ->exists();
    }

    public static function getLastSprintNumberForProject(int $project_id): ?int
    {
        return Sprint::where('project_id', $project_id)->max('sprint_nr');
    }
}
