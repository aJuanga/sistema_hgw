<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // JEFA
        $jefa = User::create([
            'name' => 'María Gonzales',
            'email' => 'jefa@healthyglow.com',
            'password' => Hash::make('jefa123'),
            'phone' => '70123456',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $jefa->roles()->attach(Role::where('slug', 'jefa')->first());

        // ADMINISTRADOR
        $admin = User::create([
            'name' => 'Carlos Pérez',
            'email' => 'admin@healthyglow.com',
            'password' => Hash::make('admin123'),
            'phone' => '71234567',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $admin->roles()->attach(Role::where('slug', 'administrador')->first());

        // EMPLEADOS
        $empleado1 = User::create([
            'name' => 'Ana López',
            'email' => 'empleado1@healthyglow.com',
            'password' => Hash::make('empleado123'),
            'phone' => '72345678',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $empleado1->roles()->attach(Role::where('slug', 'empleado')->first());

        $empleado2 = User::create([
            'name' => 'Juan Mamani',
            'email' => 'empleado2@healthyglow.com',
            'password' => Hash::make('empleado123'),
            'phone' => '73456789',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $empleado2->roles()->attach(Role::where('slug', 'empleado')->first());

        // CLIENTES
        $roleCliente = Role::where('slug', 'cliente')->first();

        $cliente1 = User::create([
            'name' => 'Pedro Quispe',
            'email' => 'pedro@gmail.com',
            'password' => Hash::make('cliente123'),
            'phone' => '74567890',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $cliente1->roles()->attach($roleCliente);
        Customer::create([
            'user_id' => $cliente1->id,
            'customer_type' => 'regular',
        ]);

        $cliente2 = User::create([
            'name' => 'Laura Fernández',
            'email' => 'laura@gmail.com',
            'password' => Hash::make('cliente123'),
            'phone' => '75678901',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $cliente2->roles()->attach($roleCliente);
        Customer::create([
            'user_id' => $cliente2->id,
            'customer_type' => 'regular',
        ]);

        $cliente3 = User::create([
            'name' => 'Roberto Silva',
            'email' => 'roberto@gmail.com',
            'password' => Hash::make('cliente123'),
            'phone' => '76789012',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $cliente3->roles()->attach($roleCliente);
        Customer::create([
            'user_id' => $cliente3->id,
            'customer_type' => 'vip',
        ]);

        $cliente4 = User::create([
            'name' => 'Sofía Morales',
            'email' => 'sofia@gmail.com',
            'password' => Hash::make('cliente123'),
            'phone' => '77890123',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $cliente4->roles()->attach($roleCliente);
        Customer::create([
            'user_id' => $cliente4->id,
            'customer_type' => 'regular',
        ]);
    }
}