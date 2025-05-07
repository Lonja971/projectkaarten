<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SprintGoalAndRetrospective;
use App\Models\Workprocess;

class SprintWorkprocess extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    protected $table = 'sprint_workprocesses'; 

    public $timestamps = false;

    protected $fillable = [
        'sprint_goal_id',
        'workprocess_id',
    ];

    public function sprintGoal()
    {
        return $this->belongsTo(SprintGoalAndRetrospective::class);
    }

    public function workprocess()
    {
        return $this->belongsTo(Workprocess::class);
    }

    public static function findByGoalAndProcess(int $goal_id, int $workprocess_id): ?self
    {
        return self::where('sprint_goal_id', $goal_id)
            ->where('workprocess_id', $workprocess_id)
            ->first();
    }

    public static function existsForGoalAndWorkprocess(int $goal_id, int $workprocess_id): bool
    {
        return self::where('sprint_goal_id', $goal_id)
            ->where('workprocess_id', $workprocess_id)
            ->exists();
    }
}
