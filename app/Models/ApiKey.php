<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    protected $fillable = ['api_key', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function isValid($apiKey)
    {
        return self::where('api_key', $apiKey)->exists();
    }

    public static function getUserId($api_key): ?int
    {
        return ApiKey::where('api_key', $api_key)->value('user_id');
    }
}
