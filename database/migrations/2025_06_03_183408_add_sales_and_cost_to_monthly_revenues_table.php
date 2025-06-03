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
        Schema::table('monthly_revenues', function (Blueprint $table) {
             $table->decimal('total_sales', 15, 2)->nullable();
        $table->decimal('total_cost', 15, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('monthly_revenues', function (Blueprint $table) {
                    $table->dropColumn(['total_sales', 'total_cost']);

        });
    }
};
