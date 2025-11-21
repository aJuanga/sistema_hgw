<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        // Add check constraint to prevent negative stock (compatible con múltiples motores)
        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE inventory ADD CONSTRAINT inventory_current_stock_check CHECK (current_stock >= 0)');
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE inventory ADD CONSTRAINT inventory_current_stock_check CHECK (current_stock >= 0)');
        }
        // SQLite no soporta ALTER TABLE ADD CONSTRAINT, la validación se hace en el modelo/controlador
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE inventory DROP CHECK inventory_current_stock_check');
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE inventory DROP CONSTRAINT IF EXISTS inventory_current_stock_check');
        }
    }
};
