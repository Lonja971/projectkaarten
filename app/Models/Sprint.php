<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sprint extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    protected $fillable = [];

    public function status()
    {
        return $this->belongsTo(SprintStatus::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public static function setSprintsForProject($project_id, $date_start, $date_end)
    {
        $start = Carbon::parse($date_start)->startOfDay();
        $end = Carbon::parse($date_end)->endOfDay();

        $weeks = $start->diffInWeeks($end) + 1;

        for ($week = 1; $week <= $weeks; $week++) {
            Sprint::create([
                'project_id' => $project_id,
                'week_nr' => $week,
                'status_id' => env('DEFAULT_SPRINT_STATUS_ID'),
            ]);
        }

        return true;
    }
}
