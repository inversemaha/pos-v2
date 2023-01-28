<?php

namespace Database\Seeders;

use App\Models\Outlet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OutletsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Outlet::create([
            'outlet_name' => "OuletOne",
            'outlet_phone' => "01714258963",
            'outlet_address' => "Mirpur, Dhaka",
            'outlet_image' => "outlet.png"
        ]);
    }
}
