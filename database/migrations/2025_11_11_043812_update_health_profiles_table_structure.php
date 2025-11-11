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
        Schema::table('health_profiles', function (Blueprint $table) {
            // Eliminar la restricción unique de user_id si existe
            $table->dropUnique(['user_id']);
            
            // Cambiar user_id a nullable para poder agregar customer_id después
            $table->foreignId('user_id')->nullable()->change();
            
            // Agregar nuevos campos
            $table->string('blood_type', 10)->nullable()->after('bmi');
            $table->text('health_goal')->nullable()->after('blood_type');
            $table->text('additional_notes')->nullable()->after('notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('health_profiles', function (Blueprint $table) {
            $table->dropColumn(['blood_type', 'health_goal', 'additional_notes']);
            $table->foreignId('user_id')->unique()->change();
        });
    }
};