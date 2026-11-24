<?php

namespace Database\Seeders;

use App\Models\Patient;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('fr_FR');

        for ($i = 0; $i < 15; $i++) {
            Patient::create([
                'nom'            => $faker->lastName(),
                'prenom'         => $faker->firstName(),
                'cin'            => strtoupper($faker->unique()->bothify('??######')),
                'date_naissance' => $faker->dateTimeBetween('-70 years', '-5 years')->format('Y-m-d'),
                'sexe'           => $faker->randomElement(['M', 'F']),
                'telephone'      => '06' . $faker->numerify('########'),
                'email'          => $faker->unique()->safeEmail(),
                'adresse'        => $faker->address(),
                'antecedents'    => $faker->optional(0.3)->sentence(),
            ]);
        }
    }
}
