<?php
// database/migrations/2024_01_01_000002_create_simple_relationships_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('simple_relationships', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('description')->nullable();
            $table->enum('relationship_type', ['customer', 'provider', 'partner', 'other']);
            $table->enum('status', ['active', 'inactive', 'pending'])->default('active');
            $table->string('company')->nullable();
            $table->string('position')->nullable();
            $table->json('additional_info')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('relationship_type');
            $table->index('status');
            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('simple_relationships');
    }
};