<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recommendation_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('recommendation_id')->constrained('recommendations')->onDelete('cascade');
            $table->enum('action', ['viewed', 'accepted', 'rejected', 'ignored']);
            $table->boolean('user_purchased')->default(false); // Si compró el producto recomendado
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recommendation_logs');
    }
};