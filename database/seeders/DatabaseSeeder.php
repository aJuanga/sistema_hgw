<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            CategorySeeder::class,
            PaymentMethodSeeder::class,
            DiseaseSeeder::class,
            AllergySeeder::class,
            HealthPropertySeeder::class,
            UserSeeder::class,
        ]);
    }
}