<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'exam_officer']);
        Role::create(['name' => 'lecturer']);
        Role::create(['name' => 'student']);

        // Create Admin User
        $admin = User::create([
            'name' => 'System Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'is_active' => true,
        ]);

        $admin->assignRole('admin');
    }
}
