<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Usuarios
            ['name' => 'users.view', 'module' => 'usuarios', 'description' => 'Ver usuarios'],
            ['name' => 'users.create', 'module' => 'usuarios', 'description' => 'Crear usuarios'],
            ['name' => 'users.edit', 'module' => 'usuarios', 'description' => 'Editar usuarios'],
            ['name' => 'users.delete', 'module' => 'usuarios', 'description' => 'Eliminar usuarios'],
            
            // Productos
            ['name' => 'products.view', 'module' => 'productos', 'description' => 'Ver productos'],
            ['name' => 'products.create', 'module' => 'productos', 'description' => 'Crear productos'],
            ['name' => 'products.edit', 'module' => 'productos', 'description' => 'Editar productos'],
            ['name' => 'products.delete', 'module' => 'productos', 'description' => 'Eliminar productos'],
            
            // Pedidos
            ['name' => 'orders.view', 'module' => 'pedidos', 'description' => 'Ver pedidos'],
            ['name' => 'orders.create', 'module' => 'pedidos', 'description' => 'Crear pedidos'],
            ['name' => 'orders.edit', 'module' => 'pedidos', 'description' => 'Editar pedidos'],
            ['name' => 'orders.delete', 'module' => 'pedidos', 'description' => 'Eliminar pedidos'],
            
            // Inventario
            ['name' => 'inventory.view', 'module' => 'inventario', 'description' => 'Ver inventario'],
            ['name' => 'inventory.manage', 'module' => 'inventario', 'description' => 'Gestionar inventario'],
            
            // Reportes
            ['name' => 'reports.view', 'module' => 'reportes', 'description' => 'Ver reportes'],
            ['name' => 'reports.export', 'module' => 'reportes', 'description' => 'Exportar reportes'],
            
            // Configuración
            ['name' => 'settings.view', 'module' => 'configuracion', 'description' => 'Ver configuración'],
            ['name' => 'settings.edit', 'module' => 'configuracion', 'description' => 'Editar configuración'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // Asignar todos los permisos a Jefa y Administrador
        $jefaRole = Role::where('name', 'Jefa')->first();
        $adminRole = Role::where('name', 'Administrador')->first();
        $empleadoRole = Role::where('name', 'Empleado')->first();

        $allPermissions = Permission::all();
        
        // Jefa tiene todos los permisos
        $jefaRole->permissions()->attach($allPermissions);
        
        // Administrador tiene todos los permisos
        $adminRole->permissions()->attach($allPermissions);
        
        // Empleado tiene permisos limitados
        $empleadoPermissions = Permission::whereIn('name', [
            'products.view',
            'orders.view',
            'orders.create',
            'orders.edit',
            'inventory.view',
        ])->get();
        
        $empleadoRole->permissions()->attach($empleadoPermissions);
    }
}