<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'servecore',
                'username' => 'superadmin', // Kolom unik wajib diisi
                'email' => 'phpserve@outlookcom', // Kolom unik wajib diisi
                'email_verified_at' => now(),
                'phone' => '081234567890', // Kolom unik wajib diisi
                'phone_verified_at' => now(),
                'password' => Hash::make('password'),
                'is_active' => true,
                'created_by' => 'Seeder',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'John Doe',
                'username' => 'johndoe',
                'email' => 'johndoe@example.com',
                'email_verified_at' => now(),
                'phone' => '081234567891',
                'phone_verified_at' => now(),
                'password' => Hash::make('password123'),
                'is_active' => true,
                'created_by' => 'Seeder',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        $superadmin = User::where('username', 'superadmin')->first();
        $superadmin?->assignRole('admin');

        $johndoe = User::where('username', 'johndoe')->first();
        $johndoe?->assignRole('user');
    }
}
