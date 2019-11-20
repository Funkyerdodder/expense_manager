<?php

use Illuminate\Database\Seeder;

use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Food',
            'description' => 'Chocolates'
        ]);
        Category::create([
            'name' => 'Bills',
            'description' => 'Water Bills'
        ]);
    }
}
