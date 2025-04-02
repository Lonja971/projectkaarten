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
}
