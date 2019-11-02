<?php

namespace Tests\Unit\Models\Orders;

use App\Models\Address;
use App\Models\Order;
use App\Models\ProductVariation;
use App\Models\ShippingMethod;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    /** @test */
    public function it_has_a_default_status_of_pending()
    {
        $order = factory(Order::class)->create([
            'user_id' => factory(User::class)->create()->id
        ]);

        $this->assertEquals(Order::PENDING, $order->status);
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        $order = factory(Order::class)->create([
            'user_id' => factory(User::class)->create()->id
        ]);

        $this->assertInstanceOf(User::class, $order->user);
    }

    /** @test */
    public function it_belongs_to_an_address()
    {
        $order = factory(Order::class)->create([
            'user_id' => factory(User::class)->create()->id
        ]);

        $this->assertInstanceOf(Address::class, $order->address);
    }

    /** @test */
    public function it_belongs_to_a_shipping_method()
    {
        $order = factory(Order::class)->create([
            'user_id' => factory(User::class)->create()->id
        ]);

        $this->assertInstanceOf(ShippingMethod::class, $order->shippingMethod);
    }

    /** @test */
    public function it_has_many_products()
    {
        $order = factory(Order::class)->create([
            'user_id' => factory(User::class)->create()->id
        ]);

        $order->products()->attach(
            factory(ProductVariation::class)->create(),
            [
                'quantity' => 1
            ]
        );

        $this->assertInstanceOf(ProductVariation::class, $order->products->first());
    }

    /** @test */
    public function it_has_a_quantity_attached_to_the_products()
    {
        $order = factory(Order::class)->create([
            'user_id' => factory(User::class)->create()->id
        ]);

        $order->products()->attach(
            factory(ProductVariation::class)->create(),
            [
                'quantity' => 1
            ]
        );

        $this->assertEquals(1, $order->products->first()->pivot->quantity);
    }
}
