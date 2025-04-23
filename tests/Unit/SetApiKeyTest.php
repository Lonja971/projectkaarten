<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\ApiKey;
use App\Models\User;
use Illuminate\Support\Str;

class SetApiKeyTest extends TestCase
{
    public function test_returns_existing_api_key()
    {
        $user = User::factory()->create();
        $existing_key = ApiKey::create([
            'user_id' => $user->id,
            'api_key' => 'EXISTING_KEY_123',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $result = ApiKey::setApiKeyForUser($user->id);

        $this->assertEquals($existing_key->id, $result->id);
        $this->assertEquals('EXISTING_KEY_123', $result->api_key);
    }

    public function test_creates_api_key_if_not_exists()
    {
        $user = User::factory()->create();

        $result = ApiKey::setApiKeyForUser($user->id);

        $this->assertNotNull($result);
        $this->assertEquals($user->id, $result->user_id);
        $this->assertTrue(Str::length($result->api_key) === 32);
        $this->assertDatabaseHas('api_keys', [
            'user_id' => $user->id,
            'id' => $result->id,
        ]);
    }
}