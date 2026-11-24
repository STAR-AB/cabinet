<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $utilisateurs = [
            ['name' => 'Administrateur',    'email' => 'admin@cabinet.ma',      'role' => 'admin'],
            ['name' => 'Dr. Karim Alaoui',  'email' => 'karim@cabinet.ma',      'role' => 'dentiste'],
            ['name' => 'Dr. Salma Idrissi', 'email' => 'salma@cabinet.ma',      'role' => 'dentiste'],
            ['name' => 'Nadia Bennani',     'email' => 'secretaire@cabinet.ma', 'role' => 'secretaire'],
        ];

        foreach ($utilisateurs as $u) {
            User::updateOrCreate(
                ['email' => $u['email']],
                [
                    'name'     => $u['name'],
                    'role'     => $u['role'],
                    'password' => 'password',   // haché par le cast 'hashed'
                ]
            );
        }
    }
}
