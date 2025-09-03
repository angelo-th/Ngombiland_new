<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un utilisateur admin
        User::create([
            'name' => 'Admin NGOMBILAND',
            'first_name' => 'Admin',
            'last_name' => 'NGOMBILAND',
            'email' => 'admin@ngombiland.cm',
            'phone' => '675123456',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Créer quelques utilisateurs de test
        User::create([
            'name' => 'Jean Dupont',
            'first_name' => 'Jean',
            'last_name' => 'Dupont',
            'email' => 'jean@example.com',
            'phone' => '675123457',
            'password' => Hash::make('password'),
            'role' => 'client',
        ]);

        User::create([
            'name' => 'Marie Mballa',
            'first_name' => 'Marie',
            'last_name' => 'Mballa',
            'email' => 'marie@example.com',
            'phone' => '675123458',
            'password' => Hash::make('password'),
            'role' => 'proprietor',
        ]);

        User::create([
            'name' => 'Paul Atangana',
            'first_name' => 'Paul',
            'last_name' => 'Atangana',
            'email' => 'paul@example.com',
            'phone' => '675123459',
            'password' => Hash::make('password'),
            'role' => 'investor',
        ]);
    }
}