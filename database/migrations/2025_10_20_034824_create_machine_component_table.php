<?php
// database/migrations/2024_01_01_000004_create_machine_component_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('machine_component', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machine_id')->constrained()->onDelete('cascade');
            $table->foreignId('component_id')->constrained()->onDelete('cascade');
            $table->boolean('compatible')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['machine_id', 'component_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('machine_component');
    }
};