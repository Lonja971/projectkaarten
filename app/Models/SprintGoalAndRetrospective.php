<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sprint;

class SprintGoalAndRetrospective extends Model
{
    use HasFactory;

    protected $table = 'sprint_goals_and_retrospectives';
    
    protected $guarded = [];

    protected $fillable = [
        'sprint_id',
        'description',
        'is_retrospective',
    ];

    public function sprint()
    {
        return $this->belongsTo(Sprint::class);
    }

    public function workprocesses()
    {
        return $this->hasMany(SprintWorkprocess::class, 'sprint_goal_id');
    }
}
