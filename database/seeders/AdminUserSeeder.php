<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'officielgld05@gmail.com'],
            [
                'name'     => 'Administrateur',
                'password' => Hash::make('404030'), // Mot de passe à modifier au besoin
            ]
        );
    }
}