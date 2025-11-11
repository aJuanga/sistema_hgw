<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Allergy;

class AllergySeeder extends Seeder
{
    public function run(): void
    {
        $allergies = [
            [
                'name' => 'Lactosa',
                'severity' => 'moderada',
                'description' => 'Intolerancia a la lactosa presente en lácteos',
                'is_active' => true,
            ],
            [
                'name' => 'Gluten',
                'severity' => 'severa',
                'description' => 'Alergia o intolerancia al gluten (trigo, cebada, centeno)',
                'is_active' => true,
            ],
            [
                'name' => 'Frutos Secos',
                'severity' => 'severa',
                'description' => 'Alergia a nueces, almendras, maní, etc.',
                'is_active' => true,
            ],
            [
                'name' => 'Huevo',
                'severity' => 'moderada',
                'description' => 'Alergia a las proteínas del huevo',
                'is_active' => true,
            ],
            [
                'name' => 'Soja',
                'severity' => 'moderada',
                'description' => 'Alergia a productos derivados de la soja',
                'is_active' => true,
            ],
            [
                'name' => 'Mariscos',
                'severity' => 'severa',
                'description' => 'Alergia a camarones, cangrejos y otros mariscos',
                'is_active' => true,
            ],
            [
                'name' => 'Pescado',
                'severity' => 'severa',
                'description' => 'Alergia a pescados en general',
                'is_active' => true,
            ],
        ];

        foreach ($allergies as $allergy) {
            Allergy::create($allergy);
        }
    }
}