<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recommendations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->decimal('compatibility_score', 5, 2); // 0-100%
            $table->enum('recommendation_type', ['muy_recomendado', 'recomendado', 'neutro', 'no_recomendado']);
            $table->text('explanation')->nullable(); // Por qué se recomienda o no
            $table->json('genetic_algorithm_data')->nullable(); // Datos del AG
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recommendations');
    }
};