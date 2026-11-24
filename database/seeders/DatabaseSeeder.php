<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // L'ordre est important : les rendez-vous ont besoin des users, soins et patients
        $this->call([
            UserSeeder::class,
            SoinSeeder::class,
            PatientSeeder::class,
            RendezVousSeeder::class,
        ]);
    }
}
