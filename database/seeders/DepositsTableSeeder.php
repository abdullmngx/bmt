<?php

namespace Database\Seeders;

use App\Models\Deposit;
use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepositsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plan = Plan::where('amount', 0.00)->first();
        Deposit::create([
            'user_id' => 1,
            'plan_id' => $plan->id,
            'amount' => $plan->amount,
            'expiry' => now()->addDays($plan->period),
            'status' => 'active'
        ]);
    }
}
