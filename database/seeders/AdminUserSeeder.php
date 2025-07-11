<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo admin user
        $adminRole = Role::where('name', 'admin')->first();
        $instructorRole = Role::where('name', 'instructor')->first();
        $studentRole = Role::where('name', 'student')->first();

        // Admin user
        User::firstOrCreate(
            ['email' => 'admin@hoctienganh.com'],
            [
                'name' => 'Admin',
                'email' => 'admin@hoctienganh.com',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Instructor user
        User::firstOrCreate(
            ['email' => 'instructor@hoctienganh.com'],
            [
                'name' => 'Giảng Viên Demo',
                'email' => 'instructor@hoctienganh.com',
                'password' => Hash::make('password'),
                'role_id' => $instructorRole->id,
                'is_active' => true,
                'email_verified_at' => now(),
                'bio' => 'Giảng viên tiếng Anh với 5 năm kinh nghiệm giảng dạy',
            ]
        );

        // Student user
        User::firstOrCreate(
            ['email' => 'student@hoctienganh.com'],
            [
                'name' => 'Học Viên Demo',
                'email' => 'student@hoctienganh.com',
                'password' => Hash::make('password'),
                'role_id' => $studentRole->id,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
