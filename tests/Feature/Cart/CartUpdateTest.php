<?php

namespace Tests\Feature\Cart;

use App\Models\ProductVariation;
use App\Models\User;
use Tests\TestCase;

class CartUpdateTest extends TestCase
{
    /** @test */
    public function it_fails_if_unauthenticated()
    {
        $this->json('PATCH', 'api/cart/1')
            ->assertStatus(401);
    }

    /** @test */
    public function it_fails_if_product_cant_be_found()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'PATCH', 'api/cart/1')
            ->assertStatus(404);
    }

    /** @test */
    public function it_requires_a_quantity()
    {
        $user = factory(User::class)->create();

        $product = factory(ProductVariation::class)
            ->create();

        $this->jsonAs($user, 'PATCH', "api/cart/{$product->id}")
            ->assertJsonValidationErrors(['quantity']);
    }

    /** @test */
    public function it_requires_a_numeric_quantity()
    {
        $user = factory(User::class)->create();

        $product = factory(ProductVariation::class)
            ->create();

        $this->jsonAs($user, 'PATCH', "api/cart/{$product->id}", [
            'quantity' => 'one'
        ])
            ->assertJsonValidationErrors(['quantity']);
    }

    /** @test */
    public function it_requires_a_quantity_of_one_or_more()
    {
        $user = factory(User::class)->create();

        $product = factory(ProductVariation::class)
            ->create();

        $this->jsonAs($user, 'PATCH', "api/cart/{$product->id}", [
            'quantity' => 0
        ])
            ->assertJsonValidationErrors(['quantity']);
    }

    /** @test */
    public function it_updates_the_quantity_of_a_product()
    {
        $user = factory(User::class)->create();

        $user->cart()->attach(
            $product = factory(ProductVariation::class)
                ->create(),
            [
                'quantity' => 1
            ]
        );

        $this->jsonAs($user, 'PATCH', "api/cart/{$product->id}", [
            'quantity' => $quantity = 5
        ]);

        $this->assertDatabaseHas('cart_user', [
            'product_variation_id' => $product->id,
            'quantity' => $quantity
        ]);
    }
}
