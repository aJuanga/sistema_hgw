<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('health_profile_disease', function (Blueprint $table) {
            $table->id();
            $table->foreignId('health_profile_id')->constrained('health_profiles')->onDelete('cascade');
            $table->foreignId('disease_id')->constrained('diseases')->onDelete('cascade');
            $table->date('diagnosed_at')->nullable(); // Fecha de diagnóstico
            $table->timestamps();
            
            $table->unique(['health_profile_id', 'disease_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('health_profile_disease');
    }
};