<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(
            function () {
                $users = [
                    [
                        'id' => (string) Str::uuid()->toString(), // Wajib di-generate manual jika pakai array biasa
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
                        'id' => (string) Str::uuid()->toString(), // Wajib di-generate manual jika pakai array biasa
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
            }
        );
    }
}
