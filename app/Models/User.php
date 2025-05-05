<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role; // Add this line to import the Role model
use App\Models\Project; // Add this line to import the Project model

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'role_id',
        'identifier',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role_id' => 'integer'
        ];
    }

    /**
     * Get the role associated with the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    
    /**
     * Get the projects belonging to the user.
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
    
    public static function isTeacher($user_id)
    {
        return User::where('id', $user_id)->where('role_id', env('TEACHER_ROLE_ID'))->exists();
    }

    public static function incrementProjectIndex(int $user_id): ?int
    {
        $user = User::find($user_id);
    
        if (!$user) {
            return null;
        }
    
        $user->increment('project_index');
        return $user->project_index;
    }
}
