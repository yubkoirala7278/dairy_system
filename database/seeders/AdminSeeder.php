<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'व्यवस्थापक',
            'password' => Hash::make('11111'),
            'owner_name' => 'व्यवस्थापक',
            'farmer_number' => "०",
            'location' => 'महुली',
            'gender' => 'पुरुष',
            'status' => 'चालू',
            'phone_number' => '९८०४७२६६४०',
        ]);
        $user->assignRole('admin');
    }
}
