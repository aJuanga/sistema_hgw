<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_health_property', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('health_property_id')->constrained('health_properties')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['product_id', 'health_property_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_health_property');
    }
};