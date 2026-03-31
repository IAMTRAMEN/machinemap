<?php
// database/migrations/2024_01_01_000007_create_quote_components_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quote_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_id')->constrained()->onDelete('cascade');
            $table->foreignId('component_id')->constrained()->onDelete('cascade');
            $table->decimal('unit_price', 10, 2);
            $table->integer('quantity')->default(1);
            $table->integer('installation_time')->default(0);
            $table->timestamps();
            
            $table->unique(['quote_id', 'component_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_components');
    }
};