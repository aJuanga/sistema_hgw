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
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('payment_method_id')->nullable()->after('user_id')->constrained('payment_methods')->onDelete('set null');
            $table->integer('estimated_time')->default(0)->after('total')->comment('Tiempo estimado en minutos');
            $table->timestamp('delivered_at')->nullable()->after('estimated_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['payment_method_id']);
            $table->dropColumn(['payment_method_id', 'estimated_time', 'delivered_at']);
        });
    }
};