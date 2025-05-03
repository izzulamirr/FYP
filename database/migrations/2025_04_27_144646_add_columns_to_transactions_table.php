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
            $table->string('order_id')->unique()->after('id'); // Unique order ID
            $table->json('products')->nullable()->after('order_id'); // JSON field for products
            $table->decimal('total_price', 10, 2)->nullable()->after('products'); // Total price
            $table->string('payment_method')->nullable()->after('total_price'); // Payment method
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['order_id', 'products', 'total_price', 'payment_method']);

        });
    }
};
