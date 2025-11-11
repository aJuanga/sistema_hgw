<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario Jefa
        $jefa = User::create([
            'name' => 'Jefa HGW',
            'email' => 'jefa@hgw.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        $jefeRole = Role::where('name', 'Jefa')->first();
        $jefa->roles()->attach($jefeRole);

        // Usuario Administrador
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@hgw.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        $adminRole = Role::where('name', 'Administrador')->first();
        $admin->roles()->attach($adminRole);

        // Usuario Empleado
        $empleado = User::create([
            'name' => 'Empleado HGW',
            'email' => 'empleado@hgw.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        $empleadoRole = Role::where('name', 'Empleado')->first();
        $empleado->roles()->attach($empleadoRole);

        // Usuario Cliente de Prueba
        $cliente = User::create([
            'name' => 'Cliente Prueba',
            'email' => 'cliente@test.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        $clienteRole = Role::where('name', 'Cliente')->first();
        $cliente->roles()->attach($clienteRole);
    }
}