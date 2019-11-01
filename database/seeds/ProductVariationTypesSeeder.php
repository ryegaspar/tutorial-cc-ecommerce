<?php

use App\Models\ProductVariationType;
use Illuminate\Database\Seeder;

class ProductVariationTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductVariationType::create([
            'name' => 'Ground'
        ]);

        ProductVariationType::create([
            'name' => 'Whole Bean'
        ]);
    }
}
