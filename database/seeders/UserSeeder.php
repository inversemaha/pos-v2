<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'user_name' => "Motiur",
            'user_email' => "memotiur@gmail.com",
            'user_type' => "1",
            'password' => Hash::make('123456'),
            'role_id' => ('1'),
        ]);

        User::create([
            'user_name' => "Sales man",
            'user_email' => "sales@pixonlab.com",
            'user_type' => "2",
            'password' => Hash::make('123456'),
            'role_id' => ('2'),
        ]);
    }
}
