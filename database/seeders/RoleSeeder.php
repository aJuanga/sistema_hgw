<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Crear Roles
        $jefa = Role::create([
            'name' => 'Jefa',
            'slug' => 'jefa',
            'description' => 'Dueña del negocio - Acceso total',
            'is_active' => true,
        ]);

        $admin = Role::create([
            'name' => 'Administrador',
            'slug' => 'administrador',
            'description' => 'Administrador del sistema - Acceso casi total',
            'is_active' => true,
        ]);

        $empleado = Role::create([
            'name' => 'Empleado',
            'slug' => 'empleado',
            'description' => 'Empleado - Gestión de pedidos e inventario',
            'is_active' => true,
        ]);

        $cliente = Role::create([
            'name' => 'Cliente',
            'slug' => 'cliente',
            'description' => 'Cliente - Realizar pedidos',
            'is_active' => true,
        ]);

        // Crear Permisos
        $permisos = [
            // Usuarios
            ['name' => 'ver_usuarios', 'module' => 'usuarios', 'description' => 'Ver lista de usuarios'],
            ['name' => 'crear_usuarios', 'module' => 'usuarios', 'description' => 'Crear nuevos usuarios'],
            ['name' => 'editar_usuarios', 'module' => 'usuarios', 'description' => 'Editar usuarios'],
            ['name' => 'eliminar_usuarios', 'module' => 'usuarios', 'description' => 'Eliminar usuarios'],
            
            // Productos
            ['name' => 'ver_productos', 'module' => 'productos', 'description' => 'Ver productos'],
            ['name' => 'crear_productos', 'module' => 'productos', 'description' => 'Crear productos'],
            ['name' => 'editar_productos', 'module' => 'productos', 'description' => 'Editar productos'],
            ['name' => 'eliminar_productos', 'module' => 'productos', 'description' => 'Eliminar productos'],
            
            // Pedidos
            ['name' => 'ver_pedidos', 'module' => 'pedidos', 'description' => 'Ver pedidos'],
            ['name' => 'crear_pedidos', 'module' => 'pedidos', 'description' => 'Crear pedidos'],
            ['name' => 'editar_pedidos', 'module' => 'pedidos', 'description' => 'Editar pedidos'],
            ['name' => 'cancelar_pedidos', 'module' => 'pedidos', 'description' => 'Cancelar pedidos'],
            
            // Inventario
            ['name' => 'ver_inventario', 'module' => 'inventario', 'description' => 'Ver inventario'],
            ['name' => 'crear_inventario', 'module' => 'inventario', 'description' => 'Registrar entradas'],
            ['name' => 'editar_inventario', 'module' => 'inventario', 'description' => 'Ajustar inventario'],
            
            // Reportes
            ['name' => 'ver_reportes', 'module' => 'reportes', 'description' => 'Ver reportes'],
            ['name' => 'exportar_reportes', 'module' => 'reportes', 'description' => 'Exportar reportes'],
            
            // Clientes
            ['name' => 'ver_clientes', 'module' => 'clientes', 'description' => 'Ver clientes'],
            ['name' => 'editar_clientes', 'module' => 'clientes', 'description' => 'Editar clientes'],
            
            // Proveedores
            ['name' => 'ver_proveedores', 'module' => 'proveedores', 'description' => 'Ver proveedores'],
            ['name' => 'crear_proveedores', 'module' => 'proveedores', 'description' => 'Crear proveedores'],
            ['name' => 'editar_proveedores', 'module' => 'proveedores', 'description' => 'Editar proveedores'],
        ];

        foreach ($permisos as $permiso) {
            Permission::create($permiso);
        }

        // Asignar permisos a JEFA (TODOS)
        $jefa->permissions()->attach(Permission::all());

        // Asignar permisos a ADMINISTRADOR (todos menos eliminar usuarios)
        $admin->permissions()->attach(
            Permission::where('name', '!=', 'eliminar_usuarios')->get()
        );

        // Asignar permisos a EMPLEADO
        $empleado->permissions()->attach(
            Permission::whereIn('name', [
                'ver_productos',
                'ver_pedidos',
                'crear_pedidos',
                'editar_pedidos',
                'ver_inventario',
                'crear_inventario',
                'ver_clientes',
            ])->get()
        );

        // Asignar permisos a CLIENTE
        $cliente->permissions()->attach(
            Permission::whereIn('name', [
                'ver_productos',
                'crear_pedidos',
                'ver_pedidos',
            ])->get()
        );
    }
}