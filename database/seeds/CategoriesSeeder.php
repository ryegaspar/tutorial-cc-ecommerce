<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name'      => 'Toys',
            'slug'      => 'toys',
            'parent_id' => null
        ]);

        Category::create([
            'name'      => 'School',
            'slug'      => 'school-supplies',
            'parent_id' => null
        ]);

        Category::create([
            'name'      => 'Child One',
            'slug'      => 'child-one',
            'parent_id' => 1
        ]);

        Category::create([
            'name'      => 'Child Two',
            'slug'      => 'child-two',
            'parent_id' => 1
        ]);
    }
}
