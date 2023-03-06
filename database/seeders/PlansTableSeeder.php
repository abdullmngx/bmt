<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [
            [
                'name' => "VIP 0",
                'amount' => 0.00,
                'period' => 30,
                'daily_earning' => 0.5,
                'status' => 'active'
            ],
            [
                'name' => "VIP 1",
                'amount' => 20,
                'period' => 30,
                'daily_earning' => 1,
                'status' => 'active'
            ],
            [
                'name' => "VIP 2",
                'amount' => 30,
                'period' => 30,
                'daily_earning' => 1.50,
                'status' => 'active'
            ],
            [
                'name' => "VIP 3",
                'amount' => 50,
                'period' => 30,
                'daily_earning' => 2.5,
                'status' => 'active'
            ],
            [
                'name' => "VIP 4",
                'amount' => 100,
                'period' => 30,
                'daily_earning' => 5.16,
                'status' => 'active'
            ],
            [
                'name' => "VIP 5",
                'amount' => 200,
                'period' => 30,
                'daily_earning' => 10.30,
                'status' => 'active'
            ],
            [
                'name' => "VIP 6",
                'amount' => 300,
                'period' => 30,
                'daily_earning' => 15.5,
                'status' => 'active'
            ],
            [
                'name' => "VIP 7",
                'amount' => 500,
                'period' => 30,
                'daily_earning' => 28.83,
                'status' => 'active'
            ],
            [
                'name' => "VIP 8",
                'amount' => 700,
                'period' => 30,
                'daily_earning' => 37.3,
                'status' => 'active'
            ],
            [
                'name' => "VIP 9",
                'amount' => 1000,
                'period' => 30,
                'daily_earning' => 53.3,
                'status' => 'active'
            ],
            [
                'name' => "VIP 10",
                'amount' => 1500,
                'period' => 30,
                'daily_earning' => 80,
                'status' => 'active'
            ]
        ];

        Plan::insert($plans);
    }
}
