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
}
