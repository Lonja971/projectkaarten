<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Icon;
use App\Models\Background;
use App\Models\ProjectStatus;
use App\Models\User;

class Project extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    
    public function status()
    {
        return $this->belongsTo(ProjectStatus::class);
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
}
