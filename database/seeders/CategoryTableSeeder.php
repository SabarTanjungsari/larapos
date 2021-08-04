<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=CategoryTableSeeder
     * @return void
     */
    public function run()
    {
        Category::factory()->count(15)->create();
    }
}
