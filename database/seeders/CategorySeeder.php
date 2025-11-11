<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Bebidas Calientes',
                'slug' => 'bebidas-calientes',
                'description' => 'Café, té y bebidas calientes saludables',
                'icon' => '☕',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Bebidas Frías',
                'slug' => 'bebidas-frias',
                'description' => 'Jugos naturales, smoothies y batidos',
                'icon' => '🥤',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Desayunos',
                'slug' => 'desayunos',
                'description' => 'Opciones saludables para comenzar el día',
                'icon' => '🍳',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Snacks Saludables',
                'slug' => 'snacks-saludables',
                'description' => 'Bocadillos nutritivos y ligeros',
                'icon' => '🥗',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Postres',
                'slug' => 'postres',
                'description' => 'Postres saludables y sin azúcar refinada',
                'icon' => '🍰',
                'order' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}