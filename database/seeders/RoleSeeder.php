<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['farmer', 'dairy_manager', 'financial_manager', 'admin'];
        foreach ($roles as $role) {
            Role::create([
                'name' => $role
            ]);
        }
    }
}
