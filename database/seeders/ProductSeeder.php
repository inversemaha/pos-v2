<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $product_array = array(
            'product_name' => "Fried Rice",
            'product_category_id' => rand(1, 3),
            'product_description' => "",
            'product_image' => "rice.jpg",
            'outlet_id' => 1
        );
        $product_details_array = array(
            'barcode' => rand(1, 500),
            'product_purchase_price' =>  rand(1, 500),
            'product_retail_price' => rand(1, 500),
            'outlet_id' => 1
        );

        $product_id = Product::insertGetId($product_array);
        $product_details_array['product_id'] = $product_id;
        ProductDetail::create($product_details_array);

        //Second Product
        $product_array = array(
            'product_name' => "Soup",
            'product_category_id' => 2,
            'product_description' => "",
            'product_image' => "soup.jpg",
            'outlet_id' => 1
        );
        $product_details_array = array(
            'barcode' => rand(1, 500),
            'product_purchase_price' => 80,
            'product_retail_price' => 80,
            'outlet_id' => 1
        );
        $product_id = Product::insertGetId($product_array);
        $product_details_array['product_id'] = $product_id;
        ProductDetail::create($product_details_array);

//3rd Product
        $product_array = array(
            'product_name' => "Chicken Curry",
            'product_category_id' => 3,
            'product_description' => "",
            'product_image' => "chicken.jpg",
            'outlet_id' => 1
        );
        $product_details_array = array(
            'barcode' => rand(1, 500),
            'product_purchase_price' => 120,
            'product_retail_price' => 120,
            'outlet_id' => 1
        );
        $product_id = Product::insertGetId($product_array);
        $product_details_array['product_id'] = $product_id;
        ProductDetail::create($product_details_array);

    }
}
