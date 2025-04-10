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
        'date_end'
    ];

    public function status()
    {
        return $this->belongsTo(SprintStatus::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public static function getNewSprintNr($project_id)
    {
        $last_sprint = Sprint::where('project_id', $project_id)->latest('id')->first();
        
        return $last_sprint ? $last_sprint->sprint_nr + 1 : 1;
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
}
