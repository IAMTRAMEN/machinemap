<?php
// database/migrations/2024_01_01_000001_create_machines_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // R230, R240, etc.
            $table->string('display_name');
            $table->text('description');
            $table->decimal('base_price', 12, 2);
            $table->json('specifications')->nullable();
            $table->string('image_url')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('machines');
    }
};