<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ========================
        // SUPER ADMIN
        // ========================
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'division_id' => null,
        ]);

        // ========================
        // LEADERS (division_id optional)
        // ========================
        $leaders = [
            ['Barista Leader', 'leader@barista.com'],
            ['Kitchen Leader', 'leader@kitchen.com'],
            ['Pastry Leader', 'leader@pastry.com'],
            ['Service Leader', 'leader@service.com'],
        ];

        foreach ($leaders as $index => $leader) {
            User::create([
                'name' => $leader[0],
                'email' => $leader[1],
                'password' => bcrypt('password'),
                'role' => 'leader',
                'division_id' => null, // karena kolom tidak ada di migration
            ]);
        }

        // ========================
        // FINANCE USER
        // ========================
        User::create([
            'name' => 'Finance & Purchasing',
            'email' => 'finance@finance.com',
            'password' => bcrypt('password'),
            'role' => 'finance',
            'division_id' => null,
        ]);
    }
}
