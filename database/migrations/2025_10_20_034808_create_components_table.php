<?php
// database/migrations/2024_01_01_000003_create_components_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('code')->unique(); // WS-01, FL-02, etc.
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('installation_time')->default(0); // in hours
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('components');
    }
};