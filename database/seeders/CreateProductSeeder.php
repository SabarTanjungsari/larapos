<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;;

use Illuminate\Support\Str;

class CreateProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = Category::create(['name' => 'Standard Category']);
        $product = Product::create([
            'name' => 'Standard Product',
            'stock' => 1,
            'price' => 10000,
            'category_id' => $category->id,
            'code' => Str::random(10)
        ]);
    }
}
