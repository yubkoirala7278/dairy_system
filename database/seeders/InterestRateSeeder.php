<?php

namespace Database\Seeders;

use App\Models\InterestRate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InterestRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        InterestRate::create([
            'compound_interest_rate'=>4
        ]);
    }
}
