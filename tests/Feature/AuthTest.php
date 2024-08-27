<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_register()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '1234567890',
            'address' => 'Test Address',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson('/api/v1/register', $userData);
        $response->assertStatus(201);

        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    #[Test]
    public function user_can_login()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/v1/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);
        $response->assertStatus(200)
            ->assertJsonStructure(['token', 'refresh_token', 'user']);
    }

    #[Test]
    public function user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $response = $this->postJson('/api/v1/login', [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ]);
        $response->assertStatus(401);
    }
}
