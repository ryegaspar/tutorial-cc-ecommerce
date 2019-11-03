<?php

namespace Tests\Unit\Collections;

use App\Models\Collections\ProductVariationCollection;
use App\Models\ProductVariation;
use App\Models\User;
use Tests\TestCase;

class ProductVariationCollectionTest extends TestCase
{
    /** @test */
    public function it_can_get_a_syncing_array()
    {
        $user = factory(User::class)->create();

        $user->cart()->attach(
            $product = factory(ProductVariation::class)->create(),
            [
                'quantity' => $quantity = 2
            ]
        );

        $collection = new ProductVariationCollection($user->cart);

        $this->assertEquals(
            [
                $product->id => [
                    'quantity' => 2
                ]
            ], $collection->forSyncing());
    }
}
