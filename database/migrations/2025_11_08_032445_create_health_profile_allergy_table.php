<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('health_profile_allergy', function (Blueprint $table) {
            $table->id();
            $table->foreignId('health_profile_id')->constrained('health_profiles')->onDelete('cascade');
            $table->foreignId('allergy_id')->constrained('allergies')->onDelete('cascade');
            $table->text('reaction_description')->nullable();
            $table->timestamps();
            
            $table->unique(['health_profile_id', 'allergy_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('health_profile_allergy');
    }
};