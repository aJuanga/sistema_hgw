<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('product_ratings')) {
            Schema::create('product_ratings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
                $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('set null');
                $table->integer('rating')->comment('Calificación de 1 a 5');
                $table->text('comment')->nullable();
                $table->timestamps();

                $table->unique(['user_id', 'product_id', 'order_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('product_ratings');
    }
};


