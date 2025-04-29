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
            Schema::table('transactions', function (Blueprint $table) {
                if (!Schema::hasColumn('transactions', 'order_id')) {
                    $table->string('order_id')->after('id');
                }
                if (!Schema::hasColumn('transactions', 'products')) {
                    $table->json('products')->nullable()->after('order_id');
                }
                if (!Schema::hasColumn('transactions', 'quantity')) {
                    $table->integer('quantity')->nullable()->after('products');
                }
                if (!Schema::hasColumn('transactions', 'total_price')) {
                    $table->decimal('total_price', 10, 2)->nullable()->after('quantity');
                }
                if (!Schema::hasColumn('transactions', 'payment_method')) {
                    $table->string('payment_method')->nullable()->after('total_price');
                }
            });
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
