<?php

use App\Models\ProductVariation;
use Illuminate\Database\Seeder;

class ProductVariationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductVariation::create([
            'product_id'                => 1,
            'product_variation_type_id' => 1,
            'name'                      => '250g',
            'price'                     => null
        ]);

        ProductVariation::create([
            'product_id'                => 1,
            'product_variation_type_id' => 1,
            'name'                      => '500g',
            'price'                     => 1500
        ]);

        ProductVariation::create([
            'product_id'                => 1,
            'product_variation_type_id' => 1,
            'name'                      => '1kg',
            'price'                     => 2000
        ]);

        ProductVariation::create([
            'product_id'                => 1,
            'product_variation_type_id' => 2,
            'name'                      => '250g',
            'price'                     => null
        ]);

        ProductVariation::create([
            'product_id'                => 1,
            'product_variation_type_id' => 2,
            'name'                      => '500g',
            'price'                     => 1500
        ]);

        ProductVariation::create([
            'product_id'                => 1,
            'product_variation_type_id' => 2,
            'name'                      => '1kg',
            'price'                     => 2000
        ]);


    }
}
