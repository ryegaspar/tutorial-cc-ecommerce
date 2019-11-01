<?php

use App\Models\ShippingMethod;
use Illuminate\Database\Seeder;

class ShippingMethodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShippingMethod::create([
            'name'  => 'ups',
            'price' => 1000
        ]);

        ShippingMethod::create([
            'name'  => 'royal',
            'price' => 1200
        ]);

        ShippingMethod::create([
            'name'  => 'usps',
            'price' => 900
        ]);
    }
}
