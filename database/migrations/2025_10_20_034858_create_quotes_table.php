<?php
// database/migrations/2024_01_01_000006_create_quotes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('quote_number')->unique();
            $table->foreignId('machine_id')->constrained()->onDelete('cascade');
            $table->decimal('total_price', 12, 2);
            $table->integer('total_installation_time')->default(0);
            
            // Customer information
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_company')->nullable();
            $table->string('customer_phone')->nullable();
            
            // Configuration details
            $table->json('configuration_data')->nullable();
            $table->text('notes')->nullable();
            
            $table->string('status')->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};