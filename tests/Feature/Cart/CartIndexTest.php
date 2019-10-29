<?php

namespace Tests\Feature\Cart;

use App\Models\ProductVariation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartIndexTest extends TestCase
{
    /** @test */
    public function it_fails_if_unauthenticated()
    {
        $this->json('Get', 'api/cart')
            ->assertStatus(401);
    }

    /** @test */
    public function it_shows_products_in_the_user_cart()
    {
        $user = factory(User::class)->create();

        $user->cart()->sync(
            $product = factory(ProductVariation::class)->create()
        );

        $response = $this->jsonAs($user, 'GET', 'api/cart')
            ->assertJsonFragment([
                'id' => $product->id
            ]);
    }

    /** @test */
    public function it_shows_if_the_cart_is_empty()
    {
        $user = factory(User::class)->create();

        $response = $this->jsonAs($user, 'GET', 'api/cart')
            ->assertJsonFragment([
                'empty' => true
            ]);
    }

    /** @test */
    public function it_shows_a_formatted_subtotal()
    {
        $user = factory(User::class)->create();

        $response = $this->jsonAs($user, 'GET', 'api/cart')
            ->assertJsonFragment([
                'subtotal' => '$0.00'
            ]);
    }

    /** @test */
    public function it_shows_a_formatted_total()
    {
        $user = factory(User::class)->create();

        $response = $this->jsonAs($user, 'GET', 'api/cart')
            ->assertJsonFragment([
                'total' => '$0.00'
            ]);
    }
}
