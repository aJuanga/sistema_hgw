<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // Primero roles y permisos (RoleSeeder crea ambos)
            RoleSeeder::class,
            
            // Luego datos base
            CategorySeeder::class,
            PaymentMethodSeeder::class,
            DiseaseSeeder::class,
            AllergySeeder::class,
            HealthPropertySeeder::class,
            
            // Por último usuarios (necesita roles creados)
            UserSeeder::class,
        ]);
    }
}