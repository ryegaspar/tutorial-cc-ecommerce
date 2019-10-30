<?php

namespace Tests\Feature\Addresses;

use App\Models\Country;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddressStoreTest extends TestCase
{
    /** @test */
    public function it_fails_if_not_authenticated()
    {
        $this->json('POST', 'api/addresses')
            ->assertStatus(401);
    }

    /** @test */
    public function it_requires_a_name()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'POST', 'api/addresses')
            ->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function it_requires_address_line_1()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'POST', 'api/addresses')
            ->assertJsonValidationErrors(['address_1']);
    }

    /** @test */
    public function it_requires_a_city()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'POST', 'api/addresses')
            ->assertJsonValidationErrors(['city']);
    }

    /** @test */
    public function it_requires_a_postal_code()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'POST', 'api/addresses')
            ->assertJsonValidationErrors(['postal_code']);
    }

    /** @test */
    public function it_requires_a_country()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'POST', 'api/addresses')
            ->assertJsonValidationErrors(['country_id']);
    }

    /** @test */
    public function it_requires_a_valid_country()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'POST', 'api/addresses', [
            'country_id' => 99999
        ])
            ->assertJsonValidationErrors(['country_id']);
    }

    /** @test */
    public function it_stores_an_address()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'POST', 'api/addresses', $payload = [
            'name'        => 'John Doe',
            'address_1'   => '123 Code St.',
            'city'        => 'Tech City',
            'postal_code' => '42069',
            'country_id'  => factory(Country::class)->create()->id
        ]);

        $this->assertDatabaseHas('addresses', array_merge(
            $payload, [
                'user_id' => $user->id,
            ]
        ));
    }

    /** @test */
    public function it_returns_an_address_when_created()
    {
        $user = factory(User::class)->create();

        $response = $this->jsonAs($user, 'POST', 'api/addresses', $payload = [
            'name'        => 'John Doe',
            'address_1'   => '123 Code St.',
            'city'        => 'Tech City',
            'postal_code' => '42069',
            'country_id'  => factory(Country::class)->create()->id
        ]);

        $response->assertJsonFragment([
            'id' => json_decode($response->getContent())->data->id
        ]);
    }
}
