<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ApiKey extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $fillable = ['api_key', 'description', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function setApiKeyForUser($user_id)
    {
        $existing_api_key = self::where('user_id', $user_id)->first();
        if ($existing_api_key) {
            $existing_api_key->delete();
        }

        $api_key = Str::random(32);

        return self::create([
            'api_key' => $api_key,
            'user_id' => $user_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
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
