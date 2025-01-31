<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_products()
    {
        Product::factory()->count(5)->create();

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
                 ->assertJsonCount(5, 'data');
    }

    /** @test */
    public function it_can_create_a_product()
    {
        $user = User::factory()->create();
        $data = ['name' => 'Test Product', 'price' => 99.99];

        $response = $this->actingAs($user, 'api')->postJson('/api/products', $data);

        $response->assertStatus(201)
                 ->assertJson(['data' => ['name' => 'Test Product']]);
    }

    /** @test */
    public function it_can_update_a_product()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $updateData = ['name' => 'Updated Product'];

        $response = $this->actingAs($user, 'api')->putJson("/api/products/{$product->id}", $updateData);

        $response->assertStatus(200)
                 ->assertJson(['data' => ['name' => 'Updated Product']]);
    }

    /** @test */
    public function it_can_delete_a_product()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user, 'api')->deleteJson("/api/products/{$product->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
