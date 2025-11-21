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
        // Add check constraint to prevent negative stock
        DB::statement('ALTER TABLE inventory ADD CONSTRAINT inventory_current_stock_check CHECK (current_stock >= 0)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the check constraint
        DB::statement('ALTER TABLE inventory DROP CONSTRAINT IF EXISTS inventory_current_stock_check');
    }
};
