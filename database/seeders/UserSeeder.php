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
        // Usuario Administrador
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('Admin123'),
                'rol' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Usuario Cliente 1
        User::updateOrCreate(
            ['email' => 'cliente1@example.com'],
            [
                'name' => 'Cliente 1',
                'password' => Hash::make('Cliente123'),
                'rol' => 'cliente',
                'email_verified_at' => now(),
            ]
        );
    }
}
