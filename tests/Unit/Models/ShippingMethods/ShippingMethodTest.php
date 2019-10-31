<?php

namespace Tests\Unit\Models\ShippingMethods;

use App\Cart\Money;
use App\Models\ShippingMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShippingMethodTest extends TestCase
{
    /** @test */
    public function it_returns_a_money_instance_for_the_price()
    {
        $shipping = factory(ShippingMethod::class)->create();

        $this->assertInstanceOf(Money::class, $shipping->price);
    }

    /** @test */
    public function it_returns_a_formatted_price()
    {
        $shipping = factory(ShippingMethod::class)->create([
            'price' => 0
        ]);

        $this->assertEquals('$0.00', $shipping->formattedPrice);
    }
}
