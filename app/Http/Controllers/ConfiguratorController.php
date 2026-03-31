<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Add this line
use App\Models\Machine;
use App\Models\Category;
use App\Models\Component;
use App\Models\CompatibilityRule;
use App\Models\Quote;
use App\Models\SavedConfiguration;
use Barryvdh\DomPDF\Facade\Pdf;

class ConfiguratorController extends Controller
{
    /**
     * Show machine selection page
     */
        public function index(Request $request)
{
    $search = $request->get('search');
    
    $baseQuery = Machine::where('active', true);

    // Apply search filter if provided
    if ($search) {
        $baseQuery->where(function($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('display_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        });
    }

    // Get all matching machines
    $allMachines = $baseQuery->orderBy('base_price')->get();
    
    // Split into featured and regular (only if we have enough results)
    if ($allMachines->count() >= 3) {
        $featuredMachines = $allMachines->take(3);
        $regularMachines = $allMachines->slice(3);
    } else {
        $featuredMachines = collect();
        $regularMachines = $allMachines;
    }

    return view('configurator.index', compact('featuredMachines', 'regularMachines', 'allMachines', 'search'));
}


    /**
     * Show configuration page for a specific machine
     */
    public function show($id)
    {
        $machine = Machine::with(['compatibleComponents.category'])->findOrFail($id);
        
        // Get categories with compatible components for this machine
        $categories = Category::with(['components' => function($query) use ($machine) {
            $query->where('active', true)
                  ->whereHas('machines', function($q) use ($machine) {
                      $q->where('machine_id', $machine->id)
                        ->where('compatible', true);
                  });
        }])->whereHas('components', function($query) use ($machine) {
            $query->where('active', true)
                  ->whereHas('machines', function($q) use ($machine) {
                      $q->where('machine_id', $machine->id)
                        ->where('compatible', true);
                  });
        })->orderBy('order')->get();

        // Get popular components for this machine (components frequently selected together)
        $popularComponents = $this->getPopularComponents($machine->id);

        return view('configurator.show', compact('machine', 'categories', 'popularComponents'));
    }


 public function saveConfiguration(Request $request)
{
    $request->validate([
        'machine_id' => 'required|exists:machines,id',
        'components' => 'array',
        'components.*' => 'exists:components,id',
        'customer_name' => 'required|string|max:255',
        'customer_email' => 'required|email',
        'customer_company' => 'nullable|string|max:255',
        'customer_phone' => 'nullable|string|max:20',
    ]);

    try {
        $machine = Machine::findOrFail($request->machine_id);
        $selectedComponents = $request->components ?? [];

        // Calculate pricing
        $pricing = $this->calculatePricing($machine, $selectedComponents);

        // Create saved configuration
        $configuration = SavedConfiguration::create([
            'machine_id' => $machine->id,
            'selected_components' => $selectedComponents,
            'total_price' => $pricing['total'],
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_company' => $request->customer_company,
            'customer_phone' => $request->customer_phone,
            'notes' => $request->notes,
            'status' => 'active'
        ]);

        return response()->json([
            'success' => true,
            'configuration_number' => $configuration->configuration_number,
            'message' => 'Configuration saved successfully! You can access it later using your configuration number: ' . $configuration->configuration_number
        ]);

    } catch (\Exception $e) {
        \Log::error('Error saving configuration: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Failed to save configuration. Please try again.'
        ], 500);
    }
}
/**
 * Load a saved configuration
 */
public function loadConfiguration($configurationNumber)
{
    try {
        $configuration = SavedConfiguration::with('machine')
            ->where('configuration_number', $configurationNumber)
            ->where('status', 'active')
            ->firstOrFail();

        $machine = $configuration->machine;
        
        // Get categories with compatible components for this machine
        $categories = Category::with(['components' => function($query) use ($machine) {
            $query->where('active', true)
                  ->whereHas('machines', function($q) use ($machine) {
                      $q->where('machine_id', $machine->id)
                        ->where('compatible', true);
                  });
        }])->whereHas('components', function($query) use ($machine) {
            $query->where('active', true)
                  ->whereHas('machines', function($q) use ($machine) {
                      $q->where('machine_id', $machine->id)
                        ->where('compatible', true);
                  });
        })->orderBy('order')->get();

        $popularComponents = $this->getPopularComponents($machine->id);

        return view('configurator.show', compact('machine', 'categories', 'popularComponents', 'configuration'));

    } catch (\Exception $e) {
        \Log::error('Error loading configuration: ' . $e->getMessage());
        return redirect()->route('configurator.index')
            ->with('error', 'Configuration not found or has been deleted.');
    }
}

/**
 * List saved configurations (for admin)
 */
public function savedConfigurations()
{
    $configurations = SavedConfiguration::with('machine')
        ->latest()
        ->get();
    
    return view('admin.configurations.index', compact('configurations'));
}

/**
 * Show saved configuration details
 */
/**
 * Show saved configuration details
 */
public function showSavedConfiguration(SavedConfiguration $configuration)
{
    // Load the machine relationship
    $configuration->load('machine');
    
    // Get the components using the accessor (not relationship)
    $components = $configuration->components; // This uses the getComponentsAttribute()
    
    // Calculate pricing
    $pricing = $this->calculatePricing($configuration->machine, $configuration->selected_components ?? []);
    
    return view('admin.configurations.show', compact('configuration', 'pricing', 'components'));
}
    public function compare()
    {
        $machines = Machine::where('active', true)->get();
        return view('configurator.compare', compact('machines'));
    }

    /**
     * Get comparison data
     */
        /**
 * Get compatible components for a machine (API)
 */
    public function getMachineComponents($machineId)
    {
        try {
            $machine = Machine::findOrFail($machineId);
            $components = $machine->compatibleComponents()
                ->with('category')
                ->get()
                ->map(function($component) {
                    return [
                        'id' => $component->id,
                        'name' => $component->name,
                        'code' => $component->code,
                        'description' => $component->description,
                        'price' => (float) $component->price,
                        'installation_time' => $component->installation_time,
                        'category_name' => $component->category->name
                    ];
                });
            
            return response()->json($components);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Machine not found'], 404);
        }
    }

    /**
 * Get components for comparison (AJAX)
 */
/**
 * Get components for comparison (AJAX)
 */
/**
 * Get machine details for comparison (AJAX)
 */
public function getComparisonComponents($machineId)
{
    try {
        $machine = Machine::where('id', $machineId)
            ->where('active', true)
            ->first();
            
        if (!$machine) {
            return response()->json(['error' => 'Machine not found'], 404);
        }
        
        $components = $machine->compatibleComponents()
            ->with('category')
            ->where('active', true)
            ->get()
            ->map(function($component) {
                return [
                    'id' => $component->id,
                    'name' => $component->name,
                    'category_name' => $component->category->name
                ];
            });
        
        return response()->json($components);
    } catch (\Exception $e) {
        \Log::error('Failed to load machine components: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to load machine details'], 500);
    }
}
/**
 * Get machine details for comparison (AJAX)
 */
public function getMachineDetails($machineId)
{
    try {
        \Log::info('Loading machine details for ID: ' . $machineId);
        
        $machine = Machine::where('id', $machineId)
            ->where('active', true)
            ->first();
            
        if (!$machine) {
            \Log::warning('Machine not found or inactive: ' . $machineId);
            return response()->json(['error' => 'Machine not found or inactive'], 404);
        }
        
        // Get basic machine info with component count
        $components = $machine->compatibleComponents()
            ->where('active', true)
            ->get();
            
        $categories = $components->groupBy('category.name')->map->count();
        
        $machineData = [
            'id' => $machine->id,
            'name' => $machine->name,
            'display_name' => $machine->display_name,
            'description' => $machine->description,
            'base_price' => (float) $machine->base_price,
            'specifications' => $machine->specifications,
            'components_count' => $components->count(),
            'categories' => $categories,
            'categories_count' => $categories->count()
        ];
        
        \Log::info('Machine details loaded successfully for: ' . $machine->name);
        
        return response()->json($machineData);
    } catch (\Exception $e) {
        \Log::error('Failed to load machine details: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to load machine details: ' . $e->getMessage()], 500);
    }
}

    /**
     * Get popular components for a machine (based on quote history)
     */
    /**
 * Get intelligent component recommendations
 */
    private function getPopularComponents($machineId)
    {
        // Method 1: Most frequently purchased together
        $frequentlyBought = DB::table('quote_components as qc1')
            ->join('quote_components as qc2', function($join) {
                $join->on('qc1.quote_id', '=', 'qc2.quote_id')
                    ->where('qc1.component_id', '!=', 'qc2.component_id');
            })
            ->join('components', 'qc2.component_id', '=', 'components.id')
            ->join('quotes', 'qc1.quote_id', '=', 'quotes.id')
            ->where('quotes.machine_id', $machineId)
            ->where('components.active', true)
            ->select(
                'components.id',
                'components.name',
                'components.code',
                'components.description',
                'components.price',
                'components.category_id',
                DB::raw('COUNT(qc2.component_id) as co_occurrence_count'),
                DB::raw('AVG(components.price) as avg_price')
            )
            ->groupBy('components.id', 'components.name', 'components.code', 'components.description', 'components.price', 'components.category_id')
            ->orderByDesc('co_occurrence_count')
            ->limit(6)
            ->get();

        // Method 2: Highest value components (if above method returns few results)
        if ($frequentlyBought->count() < 3) {
            $highValue = DB::table('quote_components')
                ->join('quotes', 'quote_components.quote_id', '=', 'quotes.id')
                ->join('components', 'quote_components.component_id', '=', 'components.id')
                ->where('quotes.machine_id', $machineId)
                ->where('components.active', true)
                ->select(
                    'components.id',
                    'components.name',
                    'components.code',
                    'components.description',
                    'components.price',
                    'components.category_id',
                    DB::raw('COUNT(quote_components.component_id) as usage_count'),
                    DB::raw('AVG(components.price) as avg_price')
                )
                ->groupBy('components.id', 'components.name', 'components.code', 'components.description', 'components.price', 'components.category_id')
                ->orderByDesc('usage_count')
                ->orderByDesc('components.price')
                ->limit(6)
                ->get();

            return $highValue->count() > $frequentlyBought->count() ? $highValue : $frequentlyBought;
        }

        return $frequentlyBought;
    }


    /**
     * Validate configuration in real-time (AJAX)
     */
    public function validateConfiguration(Request $request)
    {
        $request->validate([
            'machine_id' => 'required|exists:machines,id',
            'components' => 'array',
            'components.*' => 'exists:components,id'
        ]);

        $machine = Machine::find($request->machine_id);
        $selectedComponents = $request->components ?? [];
        
        $validationResult = $this->validateComponents($selectedComponents);
        $pricing = $this->calculatePricing($machine, $selectedComponents);

        return response()->json([
            'valid' => $validationResult['valid'],
            'messages' => $validationResult['messages'],
            'pricing' => $pricing,
            'can_proceed' => $validationResult['valid']
        ]);
    }

    /**
     * Generate and show quote
     */
    public function generateQuote(Request $request)
    {
        $request->validate([
            'machine_id' => 'required|exists:machines,id',
            'components' => 'array',
            'components.*' => 'exists:components,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_company' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
        ]);

        $machine = Machine::find($request->machine_id);
        $selectedComponents = $request->components ?? [];

        // Final validation
        $validationResult = $this->validateComponents($selectedComponents);
        if (!$validationResult['valid']) {
            return redirect()->back()->withErrors(['components' => 'Selected components have compatibility issues.']);
        }

        // Calculate pricing
        $pricing = $this->calculatePricing($machine, $selectedComponents);

        // Create quote
        $quote = Quote::create([
            'machine_id' => $machine->id,
            'total_price' => $pricing['total'],
            'total_installation_time' => $pricing['installation_time'],
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_company' => $request->customer_company,
            'customer_phone' => $request->customer_phone,
            'configuration_data' => [
                'machine' => $machine->toArray(),
                'selected_components' => Component::whereIn('id', $selectedComponents)->get()->toArray(),
                'pricing_breakdown' => $pricing
            ],
            'notes' => $request->notes,
            'status' => 'draft'
        ]);

        // Attach components to quote
        foreach ($selectedComponents as $componentId) {
            $component = Component::find($componentId);
            $quote->components()->attach($componentId, [
                'unit_price' => $component->price,
                'installation_time' => $component->installation_time,
                'quantity' => 1
            ]);
        }

        return view('configurator.quote', [
    'quote' => $quote,
    'pricing' => $pricing
]);
    }

    /**
     * Export quote as PDF
     */
   /**
 * Export quote as PDF
 */
public function exportPdf($id)
{
    $quote = Quote::with(['machine', 'components.category'])->findOrFail($id);
    
    // Calculate pricing for the PDF
    $componentsPrice = $quote->components->sum('pivot.unit_price');
    $pricing = [
        'base_price' => $quote->machine->base_price,
        'components_price' => $componentsPrice,
        'total' => $quote->total_price,
        'installation_time' => $quote->total_installation_time
    ];

    $pdf = Pdf::loadView('configurator.pdf', compact('quote', 'pricing'))
             ->setPaper('a4')
             ->setOptions(['defaultFont' => 'sans-serif']);

    return $pdf->download("quote_{$quote->quote_number}.pdf");
}

    /**
     * Validate component compatibility
     */
    private function validateComponents(array $componentIds)
    {
        $rules = CompatibilityRule::with(['triggerComponent', 'targetComponent'])
                                 ->where('active', true)
                                 ->get();

        $messages = [];
        $isValid = true;

        foreach ($rules as $rule) {
            $result = $rule->check($componentIds);
            
            if ($result['applies'] && !$result['satisfied']) {
                $messages[] = [
                    'type' => $result['type'],
                    'message' => $result['message'],
                    'component_id' => $rule->target_component_id
                ];
                
                if ($rule->block_configuration) {
                    $isValid = false;
                }
            }
        }

        return [
            'valid' => $isValid,
            'messages' => $messages
        ];
    }

    /**
     * Calculate pricing and installation time
     */
        private function calculatePricing(Machine $machine, array $componentIds)
    {
        // Make sure to load components with their categories
        $components = Component::whereIn('id', $componentIds)
            ->with('category') // This is crucial
            ->get();
        
        $componentsPrice = $components->sum('price');
        $installationTime = $components->sum('installation_time');
        $total = $machine->base_price + $componentsPrice;

        return [
            'base_price' => $machine->base_price,
            'components_price' => $componentsPrice,
            'total' => $total,
            'installation_time' => $installationTime,
            'components' => $components->map(function($component) {
                return [
                    'id' => $component->id,
                    'name' => $component->name,
                    'code' => $component->code,
                    'price' => (float) $component->price,
                    'category_name' => $component->category->name ?? 'Uncategorized', // Add fallback
                    'description' => $component->description,
                    'installation_time' => $component->installation_time
                ];
            })->toArray()
        ];
    }
}