<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HealthProperty;

class HealthPropertySeeder extends Seeder
{
    public function run(): void
    {
        $properties = [
            [
                'name' => 'Controla Glucosa',
                'slug' => 'controla-glucosa',
                'description' => 'Ayuda a controlar los niveles de azúcar en sangre',
                'icon' => '🩺',
                'is_active' => true,
            ],
            [
                'name' => 'Antioxidante',
                'slug' => 'antioxidante',
                'description' => 'Rico en antioxidantes que combaten radicales libres',
                'icon' => '💚',
                'is_active' => true,
            ],
            [
                'name' => 'Digestivo',
                'slug' => 'digestivo',
                'description' => 'Favorece la digestión y salud intestinal',
                'icon' => '🌿',
                'is_active' => true,
            ],
            [
                'name' => 'Energizante',
                'slug' => 'energizante',
                'description' => 'Proporciona energía natural sin azúcares',
                'icon' => '⚡',
                'is_active' => true,
            ],
            [
                'name' => 'Bajo en Sodio',
                'slug' => 'bajo-sodio',
                'description' => 'Bajo contenido de sal, ideal para hipertensión',
                'icon' => '🧂',
                'is_active' => true,
            ],
            [
                'name' => 'Sin Azúcar Añadida',
                'slug' => 'sin-azucar',
                'description' => 'Sin azúcares refinados añadidos',
                'icon' => '🍬',
                'is_active' => true,
            ],
            [
                'name' => 'Alto en Fibra',
                'slug' => 'alto-fibra',
                'description' => 'Rico en fibra dietética',
                'icon' => '🌾',
                'is_active' => true,
            ],
            [
                'name' => 'Proteína Vegetal',
                'slug' => 'proteina-vegetal',
                'description' => 'Fuente de proteína de origen vegetal',
                'icon' => '🥜',
                'is_active' => true,
            ],
            [
                'name' => 'Bajo en Calorías',
                'slug' => 'bajo-calorias',
                'description' => 'Opción baja en calorías',
                'icon' => '🔢',
                'is_active' => true,
            ],
            [
                'name' => 'Anti-inflamatorio',
                'slug' => 'antiinflamatorio',
                'description' => 'Propiedades anti-inflamatorias naturales',
                'icon' => '🛡️',
                'is_active' => true,
            ],
        ];

        foreach ($properties as $property) {
            HealthProperty::create($property);
        }
    }
}