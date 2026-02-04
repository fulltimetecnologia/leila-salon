<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Leila',
            'email' => 'leila@salao.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Cliente Teste',
            'email' => 'cliente@test.com',
            'password' => Hash::make('password'),
            'role' => 'client',
        ]);

        $this->call([
            ServiceSeeder::class,
        ]);
    }
}
