<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmin = User::create([
            'name' => 'Superadmin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('password'),
        ]);

        // Assign admin role
        $superadminRole = Role::where('name', 'superadmin')->first();
        $superadmin->assignRole($superadminRole);

        // Create a member user
        $admin= User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        // Assign member role
        $adminRole = Role::where('name', 'admin')->first();
        $admin->assignRole($adminRole);


    }
    }

