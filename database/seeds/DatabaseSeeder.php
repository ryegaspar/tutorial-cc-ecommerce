<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call([
             CountriesTableSeeder::class,
             UsersSeeder::class,
             CategoriesSeeder::class,
             ProductsSeeder::class,
             ProductVariationTypesSeeder::class,
             ProductVariationsSeeder::class,
             ShippingMethodsSeeder::class,
             StocksSeeder::class
         ]);
    }

    /*
     * products Coffee, coffee, 10000
     *** category_product 1, 1
     * country_shipping_method
     *      232     1
     *      231     2
     *      232     3
     */
}
