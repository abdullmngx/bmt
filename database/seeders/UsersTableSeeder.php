<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([[
            "name" => "abdullmng",
            "email" => "abdullmng@gmail.com",
            "phone" => "08161626675",
            "ref" => null,
            "password" => Hash::make(12345)
        ], [
            "name" => "mubie",
            "email" => "mubie009@gmail.com",
            "phone" => "08039523337",
            "ref" => 1,
            "password" => Hash::make(12345)
        ]]);
    }
}
