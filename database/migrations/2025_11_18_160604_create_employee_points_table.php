<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employee_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Empleado
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null'); // Pedido relacionado
            $table->integer('points')->default(0); // Puntos ganados
            $table->decimal('amount', 10, 2)->default(0); // Monto equivalente en dinero
            $table->string('type')->default('earned'); // earned, bonus, deduction
            $table->date('date'); // Fecha del registro (para agrupar por día)
            $table->text('description')->nullable(); // Descripción del punto
            $table->timestamps();

            // Índices para mejorar rendimiento
            $table->index('user_id');
            $table->index('date');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_points');
    }
};
