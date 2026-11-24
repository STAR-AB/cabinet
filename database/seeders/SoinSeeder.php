<?php

namespace Database\Seeders;

use App\Models\Soin;
use Illuminate\Database\Seeder;

class SoinSeeder extends Seeder
{
    public function run(): void
    {
        $soins = [
            ['Consultation',               'Examen clinique et diagnostic',   200,  30],
            ['Détartrage',                 'Nettoyage complet des dents',     400,  45],
            ['Plombage (composite)',       'Traitement d\'une carie',          500,  45],
            ['Dévitalisation',             'Traitement du canal dentaire',    800,  60],
            ['Extraction simple',          'Extraction d\'une dent',           300,  30],
            ['Extraction dent de sagesse', 'Extraction chirurgicale',         700,  60],
            ['Blanchiment',                'Blanchiment dentaire au cabinet', 1500, 60],
            ['Couronne céramique',         'Prothèse fixe en céramique',      2500, 90],
            ['Pose d\'implant',            'Implant dentaire en titane',      6000, 120],
        ];

        foreach ($soins as [$libelle, $description, $prix, $duree]) {
            Soin::updateOrCreate(
                ['libelle' => $libelle],
                ['description' => $description, 'prix' => $prix, 'duree_minutes' => $duree]
            );
        }
    }
}
