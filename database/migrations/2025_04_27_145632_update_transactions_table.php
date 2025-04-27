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
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('order_id')->unique()->after('id');
            $table->json('products')->nullable()->after('order_id');
            $table->integer('quantity')->nullable()->after('products');
            $table->decimal('total_price', 10, 2)->nullable()->after('quantity');
            $table->string('payment_method')->nullable()->after('total_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['order_id', 'products', 'quantity', 'total_price', 'payment_method']);
        });
    }
};
