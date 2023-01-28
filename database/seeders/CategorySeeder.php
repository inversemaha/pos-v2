<?php

namespace Database\Seeders;

use App\Models\ProductsCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductsCategory::create([
        'product_category_name' => "Burger",
        'product_category_image' => "rice.jpg",
        'outlet_id' => 1,
    ]);
        ProductsCategory::create([
            'product_category_name' => "Rice",
            'product_category_image' => "soup.jpg",
            'outlet_id' => 1,
        ]);
        ProductsCategory::create([
            'product_category_name' => "Chicken",
            'product_category_image' => "chicken.jpg",
            'outlet_id' => 1,
        ]);
    }
}
