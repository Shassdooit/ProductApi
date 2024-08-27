<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function admin_can_create_user()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin, 'api');

        $userData = [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'phone' => '1234567890',
            'address' => '123 Test Street',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'user',
        ];

        $response = $this->postJson('/api/v1/users', $userData);
        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => 'Test User',
                    'email' => 'testuser@example.com',
                    'phone' => '1234567890',
                    'address' => '123 Test Street',
                    'role' => 'user',
                ],
            ]);

        $this->assertDatabaseHas('users', ['email' => 'testuser@example.com']);
    }

    #[Test]
    public function non_admin_cannot_create_user()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user, 'api');

        $userData = [
            'name' => 'Another User',
            'email' => 'anotheruser@example.com',
            'phone' => '0987654321',
            'address' => '456 Another St',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'user',
        ];

        $response = $this->postJson('/api/v1/users', $userData);
        $response->assertStatus(403);
    }
}
