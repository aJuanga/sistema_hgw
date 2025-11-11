<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Jefa',
                'description' => 'Acceso total al sistema, gestión completa',
                'is_active' => true,
            ],
            [
                'name' => 'Administrador',
                'description' => 'Acceso administrativo completo',
                'is_active' => true,
            ],
            [
                'name' => 'Empleado',
                'description' => 'Gestión de pedidos y operaciones diarias',
                'is_active' => true,
            ],
            [
                'name' => 'Cliente',
                'description' => 'Usuario cliente del sistema',
                'is_active' => true,
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}