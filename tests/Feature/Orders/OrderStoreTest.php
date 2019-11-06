<?php

namespace Tests\Feature\Orders;

use App\Events\Order\OrderCreated;
use App\Models\Address;
use App\Models\ProductVariation;
use App\Models\ShippingMethod;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class OrderStoreTest extends TestCase
{
    /** @test */
    public function it_fails_if_not_authenticated()
    {
        $this->json('POST', 'api/orders')
            ->assertStatus(401);
    }

    /** @test */
    public function it_requires_an_address()
    {
        $user = factory(User::class)->create();

        $user->cart()->sync(
            $product = $this->productWithStock()
        );

        $this->jsonAs($user, 'POST', 'api/orders')
            ->assertJsonValidationErrors(['address_id']);
    }

    /** @test */
    public function it_requires_an_address_that_exists()
    {
        $user = factory(User::class)->create();

        $user->cart()->sync(
            $product = $this->productWithStock()
        );

        $this->jsonAs($user, 'POST', 'api/orders',
            [
                'address_id' => 1
            ])
            ->assertJsonValidationErrors(['address_id']);
    }

    /** @test */
    public function it_requires_an_address_that_belongs_to_the_authenticated_user()
    {
        $user = factory(User::class)->create();

        $user->cart()->sync(
            $product = $this->productWithStock()
        );

        $address = factory(Address::class)->create([
            'user_id' => factory(User::class)->create()->id
        ]);

        $this->jsonAs($user, 'POST', 'api/orders',
            [
                'address_id' => $address->id
            ])
            ->assertJsonValidationErrors(['address_id']);
    }

    /** @test */
    public function it_requires_a_shipping_method()
    {
        $user = factory(User::class)->create();

        $user->cart()->sync(
            $product = $this->productWithStock()
        );

        $this->jsonAs($user, 'POST', 'api/orders')
            ->assertJsonValidationErrors(['shipping_method_id']);
    }

    /** @test */
    public function it_requires_a_shipping_method_that_exists()
    {
        $user = factory(User::class)->create();

        $user->cart()->sync(
            $product = $this->productWithStock()
        );

        $this->jsonAs($user, 'POST', 'api/orders',
            [
                'shipping_method_id' => 1
            ])
            ->assertJsonValidationErrors(['shipping_method_id']);
    }

    /** @test */
    public function it_requires_a_shipping_method_valid_for_the_given_address()
    {
        $user = factory(User::class)->create();

        $user->cart()->sync(
            $product = $this->productWithStock()
        );

        $address = factory(Address::class)->create([
            'user_id' => $user->id,
        ]);

        $shipping = factory(ShippingMethod::class)->create();

        $this->jsonAs($user, 'POST', 'api/orders',
            [
                'shipping_method_id' => $shipping->id,
                'address_id'         => $address->id
            ])
            ->assertJsonValidationErrors(['shipping_method_id']);
    }

    /** @test */
    public function it_can_create_an_order()
    {
        $user = factory(User::class)->create();

        $user->cart()->sync(
            $product = $this->productWithStock()
        );

        list($address, $shipping) = $this->orderDependencies($user);

        $this->jsonAs($user, 'POST', 'api/orders',
            [
                'address_id'         => $address->id,
                'shipping_method_id' => $shipping->id
            ]);

        $this->assertDatabaseHas('orders',
            [
                'user_id'            => $user->id,
                'address_id'         => $address->id,
                'shipping_method_id' => $shipping->id
            ]);
    }

    /** @test */
    public function it_attaches_the_products_to_the_order()
    {
        $user = factory(User::class)->create();

        $user->cart()->sync(
            $product = $this->productWithStock()
        );

        list($address, $shipping) = $this->orderDependencies($user);

        $response = $this->jsonAs($user, 'POST', 'api/orders',
            [
                'address_id'         => $address->id,
                'shipping_method_id' => $shipping->id
            ]);

        $this->assertDatabaseHas('product_variation_order',
            [
                'product_variation_id' => $product->id,
                'order_id'             => json_decode($response->getContent())->data->id
            ]);
    }

    /** @test */
    public function it_fails_to_create_order_if_cart_is_empty()
    {
        $user = factory(User::class)->create();

        $user->cart()->sync([
            ($product = $this->productWithStock())->id => [
                'quantity' => 0
            ]
        ]);

        list($address, $shipping) = $this->orderDependencies($user);

        $this->jsonAs($user, 'POST', 'api/orders',
            [
                'address_id'         => $address->id,
                'shipping_method_id' => $shipping->id
            ])
            ->assertStatus(400);
    }

    /** @test */
    public function it_fires_an_order_created_event()
    {
        Event::fake();

        $user = factory(User::class)->create();

        $user->cart()->sync(
            $product = $this->productWithStock()
        );

        list($address, $shipping) = $this->orderDependencies($user);

        $response = $this->jsonAs($user, 'POST', 'api/orders',
            [
                'address_id'         => $address->id,
                'shipping_method_id' => $shipping->id
            ]);

        Event::assertDispatched(OrderCreated::class, function ($event) use ($response) {
            return $event->order->id === json_decode($response->getContent())->data->id;
        });
    }

    /** @test */
    public function it_empties_the_cart_when_ordering()
    {
        $user = factory(User::class)->create();

        $user->cart()->sync(
            $product = $this->productWithStock()
        );

        list($address, $shipping) = $this->orderDependencies($user);

        $response = $this->jsonAs($user, 'POST', 'api/orders',
            [
                'address_id'         => $address->id,
                'shipping_method_id' => $shipping->id
            ]);

        $this->assertEmpty($user->cart);
    }

    protected function productWithStock()
    {
        $product = factory(ProductVariation::class)->create();

        factory(Stock::class)->create([
            'product_variation_id' => $product->id
        ]);

        return $product;
    }

    protected function orderDependencies(User $user)
    {
        $address = factory(Address::class)->create([
            'user_id' => $user->id
        ]);

        $shipping = factory(ShippingMethod::class)->create();

        $shipping->countries()->attach($address->country);

        return [$address, $shipping];
    }
}
