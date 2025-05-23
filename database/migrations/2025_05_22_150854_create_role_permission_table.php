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
        Schema::create('role_permission', function (Blueprint $table) {
            $table->unsignedBigInteger('RoleID');
        $table->unsignedBigInteger('PermissionID');
        $table->foreign('RoleID')->references('RoleID')->on('roles')->onDelete('cascade');
        $table->foreign('PermissionID')->references('PermissionID')->on('permissions')->onDelete('cascade');
        $table->primary(['RoleID', 'PermissionID']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permission');
    }
};
