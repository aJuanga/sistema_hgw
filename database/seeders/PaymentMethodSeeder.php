<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $paymentMethods = [
            [
                'name' => 'Efectivo',
                'slug' => 'efectivo',
                'description' => 'Pago en efectivo al momento de la entrega',
                'is_active' => true,
            ],
            [
                'name' => 'Tarjeta de Débito',
                'slug' => 'tarjeta-debito',
                'description' => 'Pago con tarjeta de débito',
                'is_active' => true,
            ],
            [
                'name' => 'Tarjeta de Crédito',
                'slug' => 'tarjeta-credito',
                'description' => 'Pago con tarjeta de crédito',
                'is_active' => true,
            ],
            [
                'name' => 'QR',
                'slug' => 'qr',
                'description' => 'Pago mediante código QR (banco)',
                'is_active' => true,
            ],
            [
                'name' => 'Transferencia Bancaria',
                'slug' => 'transferencia',
                'description' => 'Transferencia bancaria directa',
                'is_active' => true,
            ],
        ];

        foreach ($paymentMethods as $method) {
            PaymentMethod::create($method);
        }
    }
}