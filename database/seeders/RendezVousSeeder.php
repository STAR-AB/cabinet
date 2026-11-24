<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\RendezVous;
use App\Models\Soin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RendezVousSeeder extends Seeder
{
    public function run(): void
    {
        $patients  = Patient::pluck('id');
        $dentistes = User::where('role', 'dentiste')->pluck('id');
        $soins     = Soin::pluck('id');

        for ($i = 0; $i < 12; $i++) {
            RendezVous::create([
                'patient_id'  => $patients->random(),
                'dentiste_id' => $dentistes[$i % $dentistes->count()],
                'soin_id'     => $soins->random(),
                'date_rdv'    => Carbon::today()->addDays($i % 5)->toDateString(),
                'heure_rdv'   => sprintf('%02d:00:00', 9 + intdiv($i, 5)),
                'statut'      => $i < 3 ? 'confirme' : 'planifie',
            ]);
        }
    }
}
