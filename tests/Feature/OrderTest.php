<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_create_order_from_cart()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user, 'api');

        $response = $this->postJson('/api/v1/create-order', [
            'cart_id' => $cart->id,
        ]);
        $response->assertStatus(201)
            ->assertJson(['message' => 'Order created successfully']);
    }

    #[Test]
    public function user_cannot_create_order_from_other_users_cart()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $cart = Cart::factory()->create(['user_id' => $otherUser->id]);

        $this->actingAs($user, 'api');

        $response = $this->postJson('/api/v1/create-order', [
            'cart_id' => $cart->id,
        ]);
        $response->assertStatus(404);
    }
}
