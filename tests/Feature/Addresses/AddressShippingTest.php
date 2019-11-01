<?php

namespace Tests\Feature\Addresses;

use App\Models\Address;
use App\Models\Country;
use App\Models\ShippingMethod;
use App\Models\User;
use PHPUnit\Framework\Constraint\Count;
use Tests\TestCase;

class AddressShippingTest extends TestCase
{
    /** @test */
    public function it_fails_if_the_user_is_not_authenticated()
    {
        $this->json('GET', 'api/addresses/1/shipping')
            ->assertStatus(401);
    }

    /** @test */
    public function it_fails_if_the_address_cannot_be_found()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'GET', 'api/addresses/1/shipping')
            ->assertStatus(404);
    }

    /** @test */
    public function it_fails_if_the_user_does_not_own_the_address()
    {
        $user = factory(User::class)->create();

        $address = factory(Address::class)->create([
            'user_id' => factory(User::class)->create()
        ]);

        $this->jsonAs($user, 'GET', "api/addresses/{$address->id}/shipping")
            ->assertStatus(403);
    }

    /** @test */
    public function it_shows_shipping_methods_for_the_given_address()
    {
        $user = factory(User::class)->create();

        $address = factory(Address::class)->create([
            'user_id' => $user->id,
            'country_id' => $country = factory(Country::class)->create()
        ]);

        $country->shippingMethods()->save(
            $shipping = factory(ShippingMethod::class)->create()
        );

        $this->jsonAs($user, 'GET', "api/addresses/{$address->id}/shipping")
            ->assertJsonFragment([
                'id' => $shipping->id
            ]);
    }
}
