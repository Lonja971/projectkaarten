<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Icon extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    public $timestamps = false;
    
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
