<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_view_own_cart()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user, 'api');

        $response = $this->getJson("/api/v1/carts/{$user->id}");
        $response->assertStatus(200)
            ->assertJson([
                'id' => $cart->id,
                'user_id' => $user->id,
                'product' => [],
            ]);
    }

    #[Test]
    public function user_can_add_item_to_cart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user, 'api');

        $response = $this->postJson('/api/v1/carts', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
        $response->assertStatus(200)
            ->assertJson(['message' => 'Item added successfully']);
    }

    #[Test]
    public function user_cannot_add_item_to_other_users_cart()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $product = Product::factory()->create();

        $user->cart()->create();
        $otherUser->cart()->create();

        $this->actingAs($user, 'api');

        $response = $this->postJson('/api/v1/carts', [
            'product_id' => $product->id,
            'quantity' => 2,
            'user_id' => $otherUser->id,
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Item added successfully']);

        $this->assertDatabaseHas('carts_products', [
            'cart_id' => $user->cart->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $this->assertDatabaseMissing('carts_products', [
            'cart_id' => $otherUser->cart->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
    }
}
