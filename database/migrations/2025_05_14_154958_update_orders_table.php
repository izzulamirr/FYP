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
       if (!Schema::hasTable('orders')) {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('order_id')->primary(); // Primary key
            $table->string('supplier_code'); // Foreign key to suppliers table
            $table->string('supplier_name');
            $table->decimal('total', 10, 2);
            $table->string('delivery_status')->default('pending');
            $table->date('order_date');
            $table->date('completed_date')->nullable();
            $table->string('invoice_slip')->nullable();
            $table->timestamps();

            $table->foreign('supplier_code')->references('supplier_code')->on('suppliers')->onDelete('cascade');
        });
    } else {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'supplier_name')) {
                $table->string('supplier_name');
            }
            if (!Schema::hasColumn('orders', 'total')) {
                $table->decimal('total', 10, 2);
            }
            if (!Schema::hasColumn('orders', 'delivery_status')) {
                $table->string('delivery_status')->default('pending');
            }
            if (!Schema::hasColumn('orders', 'order_date')) {
                $table->date('order_date');
            }
            if (!Schema::hasColumn('orders', 'completed_date')) {
                $table->date('completed_date')->nullable();
            }
            if (!Schema::hasColumn('orders', 'invoice_slip')) {
                $table->string('invoice_slip')->nullable();
            }
        });
    }
    }

    /**
     * Reverse the migrations.
     */
  public function down(): void
{
    if (Schema::hasTable('orders')) {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['supplier_name', 'total', 'delivery_status', 'completed_date', 'invoice_slip']);
        });
    }
}
};
