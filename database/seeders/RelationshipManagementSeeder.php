<?php
// database/seeders/RelationshipManagementSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RelationshipManagementSeeder extends Seeder
{
    public function run(): void
    {
        // Relationship Types
        $relationshipTypes = [
            // Customer relationships
            ['name' => 'End Customer', 'category' => 'customer', 'description' => 'Direct machine purchasers'],
            ['name' => 'OEM Customer', 'category' => 'customer', 'description' => 'Original Equipment Manufacturers'],
            ['name' => 'System Integrator Customer', 'category' => 'customer', 'description' => 'Companies integrating our machines into their systems'],
            
            // Component Provider relationships
            ['name' => 'Primary Component Supplier', 'category' => 'provider', 'description' => 'Main suppliers for critical components'],
            ['name' => 'Secondary Component Supplier', 'category' => 'provider', 'description' => 'Backup suppliers for components'],
            ['name' => 'Raw Material Supplier', 'category' => 'provider', 'description' => 'Suppliers of raw materials'],
            
            // Partner relationships
            ['name' => 'Integration Partner', 'category' => 'partner', 'description' => 'Partners for system integration'],
            ['name' => 'Service Partner', 'category' => 'partner', 'description' => 'Authorized service providers'],
            ['name' => 'Distribution Partner', 'category' => 'partner', 'description' => 'Sales and distribution partners'],
            ['name' => 'Technology Partner', 'category' => 'partner', 'description' => 'Technology and software partners'],
        ];

        DB::table('relationship_types')->insert($relationshipTypes);

        // Partner Service Types
        $serviceTypes = [
            ['name' => 'Machine Installation', 'description' => 'On-site machine installation and setup'],
            ['name' => 'Preventive Maintenance', 'description' => 'Scheduled maintenance services'],
            ['name' => 'Repair Services', 'description' => 'Break-fix and repair services'],
            ['name' => 'Operator Training', 'description' => 'End-user training programs'],
            ['name' => 'System Integration', 'description' => 'Integration with existing production lines'],
            ['name' => 'Custom Programming', 'description' => 'Custom software and PLC programming'],
            ['name' => '24/7 Support', 'description' => 'Round-the-clock technical support'],
        ];

        DB::table('partner_service_types')->insert($serviceTypes);

        // Sample relationship contracts types metadata
        DB::table('relationship_types')->where('name', 'Primary Component Supplier')->update([
            'metadata' => json_encode([
                'required_certifications' => ['ISO9001', 'ISO14001'],
                'quality_requirements' => ['zero_defect_policy', 'traceability'],
                'pricing_terms' => ['volume_discount', 'annual_agreement']
            ])
        ]);

        DB::table('relationship_types')->where('name', 'Integration Partner')->update([
            'metadata' => json_encode([
                'required_training' => ['mk_gilze_certification'],
                'support_levels' => ['basic', 'premium', 'enterprise'],
                'geographic_restrictions' => false
            ])
        ]);
    }
}