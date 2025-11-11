<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_disease_contraindication', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('disease_id')->constrained('diseases')->onDelete('cascade');
            $table->text('reason')->nullable(); // Razón de la contraindicación
            $table->timestamps();
            
            $table->unique(['product_id', 'disease_id'], 'product_disease_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_disease_contraindication');
    }
};