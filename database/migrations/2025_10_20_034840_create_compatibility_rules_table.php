<?php
// database/migrations/2024_01_01_000005_create_compatibility_rules_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compatibility_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            
            // Rule conditions
            $table->foreignId('trigger_component_id')->constrained('components')->onDelete('cascade');
            $table->string('operator'); // 'requires', 'incompatible_with', 'recommends'
            $table->foreignId('target_component_id')->constrained('components')->onDelete('cascade');
            
            // Actions
            $table->boolean('auto_select')->default(false);
            $table->boolean('block_configuration')->default(true);
            $table->text('error_message');
            $table->text('success_message')->nullable();
            
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compatibility_rules');
    }
};