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
  // Add the order_id column without specifying a position
        $table->string('order_id')->unique();

        // Set order_id as the primary key
        $table->primary('order_id');
             });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
// Drop the primary key constraint on order_id
            $table->dropPrimary(['order_id']);

            // Drop the order_id column
            $table->dropColumn('order_id');        });
    }
};
