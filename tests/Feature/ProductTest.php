<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_view_all_products()
    {
        $products = Product::factory(3)->create();

        $response = $this->getJson('/api/v1/products');
        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    #[Test]
    public function admin_can_create_product()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin, 'api');

        $productData = [
            'title' => 'New Product',
            'image' => 'https://example.com/image.jpg',
            'description' => 'A description for the new product',
            'price' => 1500,
        ];

        $response = $this->postJson('/api/v1/products', $productData);
        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'title' => 'New Product',
                    'image' => 'https://example.com/image.jpg',
                    'description' => 'A description for the new product',
                    'price' => 1500,
                ],
            ]);

        $this->assertDatabaseHas('products', ['title' => 'New Product']);
    }

    #[Test]
    public function non_admin_cannot_create_product()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user, 'api');

        $productData = [
            'title' => 'New Product',
            'image' => 'https://example.com/image.jpg',
            'price' => 1500,
            'description' => 'New product description',
        ];

        $response = $this->postJson('/api/v1/products', $productData);
        $response->assertStatus(403);
    }
}
