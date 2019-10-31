<?php

namespace Tests\Feature\Countries;

use App\Models\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CountryIndexTest extends TestCase
{
    /** @test */
    public function it_returns_countries()
    {
        $country = factory(Country::class)->create();

        $this->json('GET', 'api/countries')
            ->assertJsonFragment([
                'id' => $country->id
            ]);
    }
}
