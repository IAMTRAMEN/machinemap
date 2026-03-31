<?php
// database/migrations/2024_01_01_000010_create_saved_configurations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saved_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('configuration_number')->unique();
            $table->foreignId('machine_id')->constrained()->onDelete('cascade');
            $table->json('selected_components');
            $table->decimal('total_price', 12, 2);
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_company')->nullable();
            $table->string('customer_phone')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('active'); // active, archived
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saved_configurations');
    }
};