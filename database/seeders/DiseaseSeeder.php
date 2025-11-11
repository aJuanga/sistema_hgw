<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Disease;

class DiseaseSeeder extends Seeder
{
    public function run(): void
    {
        $diseases = [
            [
                'name' => 'Diabetes Tipo 1',
                'category' => 'cronica',
                'description' => 'Enfermedad crónica que afecta la producción de insulina',
                'recommendations' => 'Control estricto de azúcares, carbohidratos bajos',
                'is_active' => true,
            ],
            [
                'name' => 'Diabetes Tipo 2',
                'category' => 'cronica',
                'description' => 'Resistencia a la insulina y niveles elevados de azúcar en sangre',
                'recommendations' => 'Dieta baja en azúcares, control de carbohidratos',
                'is_active' => true,
            ],
            [
                'name' => 'Hipertensión',
                'category' => 'cronica',
                'description' => 'Presión arterial elevada',
                'recommendations' => 'Reducir consumo de sodio, evitar alimentos procesados',
                'is_active' => true,
            ],
            [
                'name' => 'Colesterol Alto',
                'category' => 'cronica',
                'description' => 'Niveles elevados de colesterol en sangre',
                'recommendations' => 'Evitar grasas saturadas, preferir alimentos ricos en omega-3',
                'is_active' => true,
            ],
            [
                'name' => 'Gastritis',
                'category' => 'cronica',
                'description' => 'Inflamación del revestimiento del estómago',
                'recommendations' => 'Evitar alimentos ácidos, picantes y café',
                'is_active' => true,
            ],
            [
                'name' => 'Enfermedad Celíaca',
                'category' => 'cronica',
                'description' => 'Intolerancia al gluten',
                'recommendations' => 'Dieta completamente libre de gluten',
                'is_active' => true,
            ],
            [
                'name' => 'Obesidad',
                'category' => 'cronica',
                'description' => 'Exceso de peso corporal',
                'recommendations' => 'Reducir calorías, aumentar actividad física',
                'is_active' => true,
            ],
        ];

        foreach ($diseases as $disease) {
            Disease::create($disease);
        }
    }
}