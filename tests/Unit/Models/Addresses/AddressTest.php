<?php

namespace Tests\Unit\Models\Addresses;

use App\Models\Address;
use App\Models\Country;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddressTest extends TestCase
{
    /** @test */
    public function it_has_one_country()
    {
        $address = factory(Address::class)->create([
            'user_id' => factory(User::class)->create()
        ]);

        $this->assertInstanceOf(Country::class, $address->country);
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        $address = factory(Address::class)->create([
            'user_id' => factory(User::class)->create()
        ]);

        $this->assertInstanceOf(User::class, $address->user);
    }

}
