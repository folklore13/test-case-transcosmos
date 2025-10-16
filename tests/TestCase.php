<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use App\Models\User;

abstract class TestCase extends BaseTestCase
{
    protected function authHeaders(User $user): array
    {
        $token = JWTAuth::fromUser($user);
        return ['Authorization' => "Bearer {$token}"];
    }

    protected function actingAsJwtUser(): array
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        return [
            'user' => $user,
            'headers' => ['Authorization' => 'Bearer ' . $token]
        ];
    }
}
