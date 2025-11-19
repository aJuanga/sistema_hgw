<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RolesAndUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles
        $roles = [
            ['name' => 'jefa', 'slug' => 'jefa', 'description' => 'Jefa - Acceso total al sistema', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'admin', 'slug' => 'admin', 'description' => 'Administrador - Gestión del sistema', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'empleado', 'slug' => 'empleado', 'description' => 'Empleado - Gestión de pedidos', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'cliente', 'slug' => 'cliente', 'description' => 'Cliente - Realizar pedidos', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insert($role);
        }

        // Obtener IDs de roles
        $rolesIds = DB::table('roles')->pluck('id', 'name');

        // Crear usuarios
        $users = [
            [
                'name' => 'Jefa',
                'email' => 'jefa@hgw.com',
                'password' => Hash::make('jefa123'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
                'role' => 'jefa'
            ],
            [
                'name' => 'Administrador',
                'email' => 'admin@hgw.com',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
                'role' => 'admin'
            ],
            [
                'name' => 'Empleado',
                'email' => 'empleado@hgw.com',
                'password' => Hash::make('empleado123'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
                'role' => 'empleado'
            ],
            [
                'name' => 'Cliente',
                'email' => 'cliente@hgw.com',
                'password' => Hash::make('cliente123'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
                'role' => 'cliente'
            ],
        ];

        foreach ($users as $userData) {
            $roleName = $userData['role'];
            unset($userData['role']);

            $userId = DB::table('users')->insertGetId($userData);

            // Asignar rol al usuario
            DB::table('user_role')->insert([
                'user_id' => $userId,
                'role_id' => $rolesIds[$roleName],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Roles y usuarios creados exitosamente!');
    }
}
