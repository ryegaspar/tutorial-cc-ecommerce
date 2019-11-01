<?php

use App\Models\Stock;
use Illuminate\Database\Seeder;

class StocksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Stock::create([
            'quantity' => 20,
            'product_variation_id' => 1
        ]);

        Stock::create([
            'quantity' => 15,
            'product_variation_id' => 2
        ]);

        Stock::create([
            'quantity' => 12,
            'product_variation_id' => 4
        ]);
    }
}
