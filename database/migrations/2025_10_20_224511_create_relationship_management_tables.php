<?php
// database/migrations/2024_01_01_000000_create_relationship_management_tables.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // First, check if organizations table exists, if not create it
        if (!Schema::hasTable('organizations')) {
            Schema::create('organizations', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('type'); // customer, component_provider, partner
                $table->string('code')->unique()->nullable();
                $table->string('legal_name')->nullable();
                $table->string('tax_number')->nullable();
                $table->string('website')->nullable();
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->text('address')->nullable();
                $table->string('city')->nullable();
                $table->string('state')->nullable();
                $table->string('country')->nullable();
                $table->string('postal_code')->nullable();
                $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
                $table->json('custom_fields')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->index('type');
                $table->index('status');
            });
        }

        // Relationship Types
        Schema::create('relationship_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category'); // customer, provider, partner
            $table->string('description')->nullable();
            $table->json('metadata')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        // Partner Service Types
        Schema::create('partner_service_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        // Component Categories (if not exists)
        if (!Schema::hasTable('component_categories')) {
            Schema::create('component_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('description')->nullable();
                $table->boolean('active')->default(true);
                $table->timestamps();
            });
        }

        // Organization Relationships with shorter index names
        Schema::create('organization_relationships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_org_id')->constrained('organizations')->onDelete('cascade');
            $table->foreignId('to_org_id')->constrained('organizations')->onDelete('cascade');
            $table->foreignId('rel_type_id')->constrained('relationship_types')->onDelete('cascade');
            $table->string('description')->nullable();
            $table->date('relationship_start')->nullable();
            $table->date('relationship_end')->nullable();
            $table->enum('status', ['active', 'inactive', 'pending', 'suspended'])->default('active');
            $table->json('terms')->nullable();
            $table->decimal('performance_score', 3, 2)->nullable();
            $table->timestamps();

            // Shorter unique index name
            $table->unique(['from_org_id', 'to_org_id', 'rel_type_id'], 'org_rels_unique');
            $table->index('status', 'org_rels_status');
        });

        // Partner Services with shorter index names
        Schema::create('partner_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('org_id')->constrained('organizations')->onDelete('cascade');
            $table->foreignId('service_type_id')->constrained('partner_service_types')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->json('service_areas')->nullable();
            $table->json('certifications')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->unique(['org_id', 'service_type_id'], 'partner_services_unique');
        });

        // Provider Specializations with shorter index names
        Schema::create('provider_specializations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('org_id')->constrained('organizations')->onDelete('cascade');
            $table->foreignId('comp_cat_id')->constrained('component_categories')->onDelete('cascade');
            $table->text('expertise_areas')->nullable();
            $table->string('lead_time')->nullable();
            $table->decimal('quality_rating', 3, 2)->nullable();
            $table->json('certifications')->nullable();
            $table->boolean('preferred_supplier')->default(false);
            $table->timestamps();

            $table->unique(['org_id', 'comp_cat_id'], 'provider_specs_unique');
        });

        // Relationship Interactions
        Schema::create('relationship_interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('org_rel_id')->constrained('organization_relationships')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('interaction_type');
            $table->string('subject');
            $table->text('description');
            $table->timestamp('interaction_date');
            $table->json('participants')->nullable();
            $table->json('outcomes')->nullable();
            $table->text('next_steps')->nullable();
            $table->timestamp('follow_up_date')->nullable();
            $table->timestamps();

            $table->index('interaction_date', 'rel_ints_date');
            $table->index('interaction_type', 'rel_ints_type');
        });

        // Relationship Contracts
        Schema::create('relationship_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('org_rel_id')->constrained('organization_relationships')->onDelete('cascade');
            $table->string('contract_number')->unique();
            $table->string('contract_type');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->enum('status', ['draft', 'active', 'expired', 'terminated'])->default('draft');
            $table->json('terms')->nullable();
            $table->json('pricing_terms')->nullable();
            $table->text('notes')->nullable();
            $table->string('document_path')->nullable();
            $table->timestamps();

            $table->index('contract_number', 'rel_contracts_number');
            $table->index('status', 'rel_contracts_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('relationship_contracts');
        Schema::dropIfExists('relationship_interactions');
        Schema::dropIfExists('provider_specializations');
        Schema::dropIfExists('partner_services');
        Schema::dropIfExists('organization_relationships');
        
        if (Schema::hasTable('component_categories')) {
            Schema::dropIfExists('component_categories');
        }
        
        Schema::dropIfExists('partner_service_types');
        Schema::dropIfExists('relationship_types');
        
        if (Schema::hasTable('organizations') && !Schema::hasColumn('organizations', 'deleted_at')) {
            Schema::dropIfExists('organizations');
        }
    }
};