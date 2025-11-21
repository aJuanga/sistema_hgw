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
        Schema::table('inventory_movements', function (Blueprint $table) {
            // Change integer columns to decimal to match inventory table
            $table->decimal('quantity', 10, 2)->change();
            $table->decimal('previous_stock', 10, 2)->change();
            $table->decimal('new_stock', 10, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory_movements', function (Blueprint $table) {
            // Revert back to integer
            $table->integer('quantity')->change();
            $table->integer('previous_stock')->change();
            $table->integer('new_stock')->change();
        });
    }
};
