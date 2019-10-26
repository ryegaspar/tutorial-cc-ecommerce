<?php

namespace Tests\Unit\Models\Users;

use App\Models\ProductVariation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function it_hashes_the_password_when_creating()
    {
        $user = factory(User::class)->create([
            'password' => 'cats'
        ]);

        $this->assertNotEquals($user->password, 'cats');
    }

    /** @test */
    public function it_has_many_cart_products()
    {
        $user = factory(User::class)->create();

        $user->cart()->attach(
            factory(ProductVariation::class)->create()
        );

        $this->assertInstanceOf(ProductVariation::class, $user->cart->first());
    }

    /** @test */
    public function it_has_a_quantity_for_each_cart_product()
    {
        $user = factory(User::class)->create();

        $user->cart()->attach(
            factory(ProductVariation::class)->create(),
            [
                'quantity' => $quantity = 5
            ]
        );

        $this->assertEquals($user->cart->first()->pivot->quantity, $quantity);
    }
}
