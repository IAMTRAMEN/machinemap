<?php
// app/Http\Controllers\Admin\DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Machine;
use App\Models\Component;
use App\Models\Quote;
use App\Models\CompatibilityRule;
use App\Models\Category;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic counts
        $stats = [
            'machines_count' => Machine::count(),
            'components_count' => Component::count(),
            'quotes_count' => Quote::count(),
            'rules_count' => CompatibilityRule::count(),
            'categories_count' => Category::count(),
        ];

        // Check if relationship tables exist before querying them
        $relationshipTablesExist = Schema::hasTable('organization_relationships') && 
                                 Schema::hasTable('relationship_types');

        // Initialize ALL relationship data with safe defaults
        $relationshipStats = [
            'total_customers' => 0,
            'total_providers' => 0,
            'total_partners' => 0,
            'active_relationships' => 0,
            'recent_interactions' => 0,
        ];

        $recentInteractions = collect();
        $upcomingFollowUps = collect();
        $relationshipPerformance = collect();
        $topCustomers = collect();

        // Only query relationship data if tables exist
        if ($relationshipTablesExist) {
            try {
                // Relationship stats
                $relationshipStats = [
                    'total_customers' => $this->getCustomerCount(),
                    'total_providers' => $this->getProviderCount(),
                    'total_partners' => $this->getPartnerCount(),
                    'active_relationships' => $this->getActiveRelationshipsCount(),
                    'recent_interactions' => $this->getRecentInteractionsCount(),
                ];

                // Recent interactions
                $recentInteractions = \App\Models\RelationshipInteraction::with([
                        'relationship.fromOrganization', 
                        'relationship.toOrganization', 
                        'relationship.type',
                        'user'
                    ])
                    ->latest()
                    ->take(8)
                    ->get();

                // Upcoming follow-ups
                $upcomingFollowUps = \App\Models\RelationshipInteraction::where('follow_up_date', '>=', now())
                    ->where('follow_up_date', '<=', now()->addDays(7))
                    ->with(['relationship.fromOrganization', 'relationship.type', 'user'])
                    ->orderBy('follow_up_date')
                    ->take(5)
                    ->get();

                // Relationship performance
                $relationshipPerformance = \App\Models\OrganizationRelationship::select(
                        DB::raw('relationship_type_id'),
                        DB::raw('COUNT(*) as total'),
                        DB::raw('AVG(performance_score) as avg_score'),
                        DB::raw('SUM(CASE WHEN status = "active" THEN 1 ELSE 0 END) as active_count')
                    )
                    ->with('type')
                    ->groupBy('relationship_type_id')
                    ->get();

                // Top customers
                $topCustomers = DB::table('quotes')
                    ->join('organizations', 'quotes.organization_id', '=', 'organizations.id')
                    ->select(
                        'organizations.name',
                        'organizations.id',
                        DB::raw('COUNT(quotes.id) as quote_count'),
                        DB::raw('SUM(quotes.total_price) as total_value')
                    )
                    ->where('quotes.status', '!=', 'draft')
                    ->groupBy('organizations.id', 'organizations.name')
                    ->orderByDesc('total_value')
                    ->limit(5)
                    ->get();

            } catch (\Exception $e) {
                logger()->error('Relationship data error: ' . $e->getMessage());
            }
        }

        // Quote statistics
        $quoteStats = [
            'total' => Quote::count(),
            'draft' => Quote::where('status', 'draft')->count(),
            'sent' => Quote::where('status', 'sent')->count(),
            'accepted' => Quote::where('status', 'accepted')->count(),
            'rejected' => Quote::where('status', 'rejected')->count(),
            'total_revenue' => Quote::sum('total_price'),
            'average_quote_value' => Quote::avg('total_price') ?? 0,
        ];

        // Recent quotes with more details
        $recentQuotes = Quote::with('machine')
            ->latest()
            ->take(8)
            ->get();

        // Most popular components
        $popularComponents = DB::table('quote_components')
            ->join('components', 'quote_components.component_id', '=', 'components.id')
            ->join('categories', 'components.category_id', '=', 'categories.id')
            ->select(
                'components.name',
                'components.code',
                'categories.name as category_name',
                DB::raw('COUNT(quote_components.component_id) as usage_count'),
                DB::raw('SUM(quote_components.unit_price) as total_revenue')
            )
            ->groupBy('quote_components.component_id', 'components.name', 'components.code', 'categories.name')
            ->orderByDesc('usage_count')
            ->limit(10)
            ->get();

        // Machine usage statistics
        $machineUsage = DB::table('quotes')
            ->join('machines', 'quotes.machine_id', '=', 'machines.id')
            ->select(
                'machines.name',
                'machines.display_name',
                DB::raw('COUNT(quotes.machine_id) as quote_count'),
                DB::raw('SUM(quotes.total_price) as total_revenue')
            )
            ->groupBy('quotes.machine_id', 'machines.name', 'machines.display_name')
            ->orderByDesc('quote_count')
            ->get();

        // Monthly quote trends (last 6 months)
        $monthlyTrends = Quote::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as quote_count'),
            DB::raw('SUM(total_price) as monthly_revenue')
        )
        ->where('created_at', '>=', now()->subMonths(6))
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get();

        // Component statistics by category
        $componentStats = Category::withCount(['components as total_components'])
            ->withCount(['components as active_components' => function($query) {
                $query->where('active', true);
            }])
            ->with(['components' => function($query) {
                $query->orderBy('price', 'desc')->limit(3);
            }])
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'relationshipStats',
            'quoteStats',
            'recentQuotes',
            'recentInteractions',
            'upcomingFollowUps',
            'popularComponents',
            'machineUsage',
            'topCustomers',
            'monthlyTrends',
            'componentStats',
            'relationshipPerformance',
            'relationshipTablesExist'
        ));
    }

    /**
     * Safe methods to get relationship counts without relying on model scopes
     */
    private function getCustomerCount()
    {
        try {
            return \App\Models\OrganizationRelationship::whereHas('type', function($q) {
                $q->where('category', 'customer');
            })->where('status', 'active')->count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getProviderCount()
    {
        try {
            return \App\Models\OrganizationRelationship::whereHas('type', function($q) {
                $q->where('category', 'provider');
            })->where('status', 'active')->count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getPartnerCount()
    {
        try {
            return \App\Models\OrganizationRelationship::whereHas('type', function($q) {
                $q->where('category', 'partner');
            })->where('status', 'active')->count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getActiveRelationshipsCount()
    {
        try {
            return \App\Models\OrganizationRelationship::where('status', 'active')->count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getRecentInteractionsCount()
    {
        try {
            return \App\Models\RelationshipInteraction::whereDate('created_at', today())->count();
        } catch (\Exception $e) {
            return 0;
        }
    }
}