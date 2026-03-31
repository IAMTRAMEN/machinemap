<?php
// database/seeders/MachineConfiguratorSeeder.php

namespace Database\Seeders;

use App\Models\Machine;
use App\Models\Category;
use App\Models\Component;
use App\Models\CompatibilityRule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MachineConfiguratorSeeder extends Seeder
{
    public function run(): void
    {
        // Create Machines
        $machines = [
            [
                'name' => 'R230',
                'display_name' => 'Compact Thermoformer R230',
                'description' => 'Compact thermoformer for soft film packaging, ideal for small to medium production volumes.',
                'base_price' => 15000.00,
                'specifications' => [
                    'Film Width' => '320mm',
                    'Dye Exit' => '220mm', 
                    'Max Cycles' => '10/min',
                    'Frame Type' => 'Adjustable',
                    'Power Supply' => '380V, 50Hz'
                ]
            ],
            [
                'name' => 'R240',
                'display_name' => 'Versatile Thermoformer R240', 
                'description' => 'Versatile thermoformer for rigid film packaging with enhanced production capabilities.',
                'base_price' => 18000.00,
                'specifications' => [
                    'Film Width' => '375mm',
                    'Dye Exit' => '200mm',
                    'Max Cycles' => '12/min', 
                    'Frame Type' => 'Adjustable',
                    'Power Supply' => '380V, 50Hz'
                ]
            ],
            [
                'name' => 'R105',
                'display_name' => 'Entry-Level Thermoformer R105',
                'description' => 'Cost-effective entry-level thermoformer perfect for small batches and startups.',
                'base_price' => 12000.00,
                'specifications' => [
                    'Film Width' => '285mm',
                    'Dye Exit' => '150mm',
                    'Max Cycles' => '8/min',
                    'Frame Type' => 'Compact',
                    'Power Supply' => '220V, 50Hz'
                ]
            ]
        ];

        foreach ($machines as $machineData) {
            Machine::create($machineData);
        }

        // Create Categories
        $categories = [
            ['name' => 'Weighing System', 'slug' => 'weighing-system', 'order' => 1],
            ['name' => 'Filling System', 'slug' => 'filling-system', 'order' => 2],
            ['name' => 'Conveyor System', 'slug' => 'conveyor-system', 'order' => 3],
            ['name' => 'Control System', 'slug' => 'control-system', 'order' => 4],
            ['name' => 'Special Features', 'slug' => 'special-features', 'order' => 5],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        // Create Components
        $weighingCategory = Category::where('slug', 'weighing-system')->first();
        $fillingCategory = Category::where('slug', 'filling-system')->first();
        $conveyorCategory = Category::where('slug', 'conveyor-system')->first();
        $controlCategory = Category::where('slug', 'control-system')->first();
        $specialCategory = Category::where('slug', 'special-features')->first();

        $components = [
            // Weighing System Components
            [
                'category_id' => $weighingCategory->id,
                'name' => 'Single Head Scale',
                'code' => 'WS-001',
                'description' => 'Basic 1kg scale system for accurate weighing',
                'price' => 5000.00,
                'installation_time' => 8
            ],
            [
                'category_id' => $weighingCategory->id,
                'name' => 'Multi Head Scale',
                'code' => 'WS-002', 
                'description' => 'High-speed 12-head scale system for production lines',
                'price' => 22000.00,
                'installation_time' => 16
            ],
            [
                'category_id' => $weighingCategory->id,
                'name' => 'Check Weigher',
                'code' => 'WS-003',
                'description' => 'Quality control check weigher system',
                'price' => 8500.00,
                'installation_time' => 12
            ],

            // Filling System Components
            [
                'category_id' => $fillingCategory->id,
                'name' => 'Auger Filler',
                'code' => 'FL-001',
                'description' => 'Precision auger filler for powder products',
                'price' => 7000.00,
                'installation_time' => 10
            ],
            [
                'category_id' => $fillingCategory->id,
                'name' => 'Piston Filler', 
                'code' => 'FL-002',
                'description' => 'Liquid filling system with piston technology',
                'price' => 8500.00,
                'installation_time' => 12
            ],
            [
                'category_id' => $fillingCategory->id,
                'name' => 'Volumetric Filler',
                'code' => 'FL-003',
                'description' => 'Volumetric filling for consistent portion control',
                'price' => 6500.00,
                'installation_time' => 8
            ],

            // Conveyor System Components  
            [
                'category_id' => $conveyorCategory->id,
                'name' => 'Standard Belt Conveyor',
                'code' => 'CV-001',
                'description' => '1 meter standard belt conveyor',
                'price' => 3000.00,
                'installation_time' => 6
            ],
            [
                'category_id' => $conveyorCategory->id,
                'name' => 'Extended Belt Conveyor',
                'code' => 'CV-002',
                'description' => '2 meter extended belt conveyor for larger systems',
                'price' => 4500.00,
                'installation_time' => 8
            ],

            // Control System Components
            [
                'category_id' => $controlCategory->id,
                'name' => 'Basic PLC Control',
                'code' => 'CT-001',
                'description' => 'Basic programmable logic controller',
                'price' => 4000.00,
                'installation_time' => 16
            ],
            [
                'category_id' => $controlCategory->id, 
                'name' => 'Advanced PLC with HMI',
                'code' => 'CT-002',
                'description' => 'Advanced PLC with human-machine interface',
                'price' => 8000.00,
                'installation_time' => 24
            ],

            // Special Features
            [
                'category_id' => $specialCategory->id,
                'name' => 'Vacuum System',
                'code' => 'SF-001',
                'description' => 'Vacuum packaging capability',
                'price' => 5500.00,
                'installation_time' => 12
            ],
            [
                'category_id' => $specialCategory->id,
                'name' => 'Gas Flush System',
                'code' => 'SF-002',
                'description' => 'Modified atmosphere packaging with gas flushing',
                'price' => 7200.00, 
                'installation_time' => 14
            ],
            [
                'category_id' => $specialCategory->id,
                'name' => 'Automatic Labeling',
                'code' => 'SF-003',
                'description' => 'Integrated automatic labeling system',
                'price' => 4800.00,
                'installation_time' => 10
            ]
        ];

        foreach ($components as $componentData) {
            Component::create($componentData);
        }

        // Attach components to machines (compatibility)
        $r230 = Machine::where('name', 'R230')->first();
        $r240 = Machine::where('name', 'R240')->first();
        $r105 = Machine::where('name', 'R105')->first();

        $allComponents = Component::all();

        // R230 compatible with most components
        $r230->components()->attach($allComponents->pluck('id'), ['compatible' => true]);

        // R240 compatible with advanced components
        $r240->components()->attach($allComponents->whereIn('code', ['WS-001', 'WS-002', 'FL-002', 'CV-001', 'CV-002', 'CT-002', 'SF-001', 'SF-002'])->pluck('id'), ['compatible' => true]);

        // R105 compatible with basic components
        $r105->components()->attach($allComponents->whereIn('code', ['WS-001', 'FL-001', 'FL-003', 'CV-001', 'CT-001', 'SF-003'])->pluck('id'), ['compatible' => true]);

        // Create Compatibility Rules
        $multiScale = Component::where('code', 'WS-002')->first();
        $extendedConveyor = Component::where('code', 'CV-002')->first();
        $augerFiller = Component::where('code', 'FL-001')->first();
        $pistonFiller = Component::where('code', 'FL-002')->first();
        $vacuumSystem = Component::where('code', 'SF-001')->first();
        $gasFlush = Component::where('code', 'SF-002')->first();

        $rules = [
            [
                'name' => 'Multi-scale requires extended conveyor',
                'trigger_component_id' => $multiScale->id,
                'operator' => 'requires',
                'target_component_id' => $extendedConveyor->id,
                'block_configuration' => true,
                'error_message' => 'Multi-head scale requires the extended conveyor system (CV-002)',
                'success_message' => 'Multi-head scale compatible with conveyor system'
            ],
            [
                'name' => 'Auger and Piston incompatibility',
                'trigger_component_id' => $augerFiller->id,
                'operator' => 'incompatible_with',
                'target_component_id' => $pistonFiller->id,
                'block_configuration' => true,
                'error_message' => 'Auger filler cannot be combined with piston filler - choose one filling system',
                'success_message' => 'Filling system selection valid'
            ],
            [
                'name' => 'Vacuum and Gas Flush incompatibility',
                'trigger_component_id' => $vacuumSystem->id,
                'operator' => 'incompatible_with', 
                'target_component_id' => $gasFlush->id,
                'block_configuration' => true,
                'error_message' => 'Vacuum system cannot be combined with gas flush system - choose one packaging method',
                'success_message' => 'Packaging method selection valid'
            ]
        ];

        foreach ($rules as $ruleData) {
            CompatibilityRule::create($ruleData);
        }

        $this->command->info('Machine Configurator sample data created successfully!');
        $this->command->info('Machines: ' . Machine::count());
        $this->command->info('Components: ' . Component::count()); 
        $this->command->info('Rules: ' . CompatibilityRule::count());
    }
}