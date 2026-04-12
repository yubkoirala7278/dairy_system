<?php

namespace Database\Seeders;

use App\Models\MilkDeposit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MilkDepositSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MilkDeposit::factory()->count(500)->create();
    }
}
