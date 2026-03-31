@extends('layouts.admin')

@section('title', 'Admin Dashboard - MK Gilze Africa')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard Overview</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <span class="text-muted">Last updated: {{ now()->format('M j, Y g:i A') }}</span>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-xl-2 col-md-4 col-6 mb-4">
        <div class="card border-start-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-primary text-uppercase mb-1">
                            Machines
                        </div>
                        <div class="h5 mb-0 fw-bold text-gray-800">{{ $stats['machines_count'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-cogs fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4 col-6 mb-4">
        <div class="card border-start-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-success text-uppercase mb-1">
                            Components
                        </div>
                        <div class="h5 mb-0 fw-bold text-gray-800">{{ $stats['components_count'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-puzzle-piece fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4 col-6 mb-4">
        <div class="card border-start-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-info text-uppercase mb-1">
                            Quotes
                        </div>
                        <div class="h5 mb-0 fw-bold text-gray-800">{{ $stats['quotes_count'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-invoice fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4 col-6 mb-4">
        <div class="card border-start-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-warning text-uppercase mb-1">
                            Rules
                        </div>
                        <div class="h5 mb-0 fw-bold text-gray-800">{{ $stats['rules_count'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-random fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4 col-6 mb-4">
        <div class="card border-start-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-secondary text-uppercase mb-1">
                            Categories
                        </div>
                        <div class="h5 mb-0 fw-bold text-gray-800">{{ $stats['categories_count'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-folder fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4 col-6 mb-4">
        <div class="card border-start-dark shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-dark text-uppercase mb-1">
                            Total Revenue
                        </div>
                        <div class="h5 mb-0 fw-bold text-gray-800">€{{ number_format($quoteStats['total_revenue'], 0) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-euro-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Left Column -->
    <div class="col-lg-8">
        <!-- Quote Statistics -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Quote Statistics</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3 mb-3">
                                <div class="border rounded p-3">
                                    <div class="h4 text-primary mb-1">{{ $quoteStats['total'] }}</div>
                                    <small class="text-muted">Total Quotes</small>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="border rounded p-3">
                                    <div class="h4 text-warning mb-1">{{ $quoteStats['draft'] }}</div>
                                    <small class="text-muted">Draft</small>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="border rounded p-3">
                                    <div class="h4 text-info mb-1">{{ $quoteStats['sent'] }}</div>
                                    <small class="text-muted">Sent</small>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="border rounded p-3">
                                    <div class="h4 text-success mb-1">{{ $quoteStats['accepted'] }}</div>
                                    <small class="text-muted">Accepted</small>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h6 class="text-muted">Average Quote Value</h6>
                                        <h3 class="text-success">€{{ number_format($quoteStats['average_quote_value'], 2) }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h6 class="text-muted">Total Revenue</h6>
                                        <h3 class="text-primary">€{{ number_format($quoteStats['total_revenue'], 2) }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Quotes & Popular Components -->
        <div class="row">
            <!-- Recent Quotes -->
            <div class="col-md-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-history me-2"></i>Recent Quotes</h5>
                    </div>
                    <div class="card-body">
                        @if($recentQuotes->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentQuotes as $quote)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">{{ $quote->quote_number }}</h6>
                                        <small class="text-muted">{{ $quote->customer_name }}</small>
                                        <br>
                                        <small class="text-muted">{{ $quote->machine->display_name }}</small>
                                    </div>
                                    <div class="text-end">
                                        <strong class="text-primary">€{{ number_format($quote->total_price, 2) }}</strong>
                                        <br>
                                        <span class="badge bg-{{ $quote->status === 'accepted' ? 'success' : ($quote->status === 'rejected' ? 'danger' : 'secondary') }}">
                                            {{ strtoupper($quote->status) }}
                                        </span>
                                    </div>
                                </div>
                                <small class="text-muted">{{ $quote->created_at->diffForHumans() }}</small>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-4">
                            <i class="fas fa-file-invoice fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No quotes generated yet.</p>
                        </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('admin.quotes.index') }}" class="btn btn-sm btn-outline-success w-100">
                            View All Quotes
                        </a>
                    </div>
                </div>
            </div>

            <!-- Popular Components -->
            <div class="col-md-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Popular Components</h5>
                    </div>
                    <div class="card-body">
                        @if($popularComponents->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($popularComponents as $component)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">{{ $component->name }}</h6>
                                        <small class="text-muted">{{ $component->category_name }}</small>
                                        <br>
                                        <small class="text-muted">Code: {{ $component->code }}</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-primary">{{ $component->usage_count }} uses</span>
                                        <br>
                                        <small class="text-success">€{{ number_format($component->total_revenue, 2) }}</small>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-4">
                            <i class="fas fa-puzzle-piece fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No component usage data yet.</p>
                        </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('admin.components.index') }}" class="btn btn-sm btn-outline-warning w-100">
                            Manage Components
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Machine Usage Statistics -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-cogs me-2"></i>Machine Usage</h5>
                    </div>
                    <div class="card-body">
                        @if($machineUsage->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>Machine</th>
                                        <th class="text-center">Quotes</th>
                                        <th class="text-center">Usage Rate</th>
                                        <th class="text-end">Total Revenue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($machineUsage as $machine)
                                    @php
                                        $usageRate = $quoteStats['total'] > 0 ? ($machine->quote_count / $quoteStats['total']) * 100 : 0;
                                    @endphp
                                    <tr>
                                        <td>
                                            <strong>{{ $machine->display_name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $machine->name }}</small>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary">{{ $machine->quote_count }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-success" role="progressbar" 
                                                     style="width: {{ $usageRate }}%;" 
                                                     aria-valuenow="{{ $usageRate }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                    {{ number_format($usageRate, 1) }}%
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <strong class="text-success">€{{ number_format($machine->total_revenue, 2) }}</strong>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-4">
                            <i class="fas fa-cogs fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No machine usage data yet.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card shadow mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.machines.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add New Machine
                    </a>
                    <a href="{{ route('admin.components.create') }}" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>Add New Component
                    </a>
                    <a href="{{ route('admin.rules.create') }}" class="btn btn-info">
                        <i class="fas fa-plus me-2"></i>Add Compatibility Rule
                    </a>
                    <a href="{{ route('configurator.index') }}" class="btn btn-outline-dark" target="_blank">
                        <i class="fas fa-external-link-alt me-2"></i>Test Configurator
                    </a>
                </div>
            </div>
        </div>

        <!-- Component Categories -->
        <div class="card shadow mb-4">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0"><i class="fas fa-folder me-2"></i>Component Categories</h5>
            </div>
            <div class="card-body">
                @if($componentStats->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($componentStats as $category)
                    <div class="list-group-item px-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">{{ $category->name }}</h6>
                                <small class="text-muted">
                                    {{ $category->active_components }}/{{ $category->total_components }} active
                                </small>
                            </div>
                            <span class="badge bg-primary">{{ $category->total_components }}</span>
                        </div>
                        @if($category->components->count() > 0)
                        <div class="mt-2">
                            @foreach($category->components as $component)
                            <small class="d-block text-muted">
                                • {{ $component->name }} (€{{ number_format($component->price, 2) }})
                            </small>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-3">
                    <i class="fas fa-folder-open fa-2x text-muted mb-2"></i>
                    <p class="text-muted">No categories found.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- System Status -->
        <div class="card shadow">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>System Status</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>Configurator Status:</span>
                        <span class="badge bg-success">Operational</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>Database:</span>
                        <span class="badge bg-success">Connected</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>PDF Generation:</span>
                        <span class="badge bg-success">Active</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Last Quote:</span>
                        <span>
                            @if($recentQuotes->count() > 0)
                            {{ $recentQuotes->first()->created_at->diffForHumans() }}
                            @else
                            <span class="text-muted">Never</span>
                            @endif
                        </span>
                    </div>
                </div>
                
                <div class="mt-4 p-3 bg-light rounded">
                    <h6 class="text-center">Quick Stats</h6>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border rounded p-2 mb-2">
                                <small class="text-muted d-block">Avg. Components</small>
                                <strong>
                                    @if($quoteStats['total'] > 0)
                                    {{ number_format($stats['components_count'] / $stats['machines_count'], 1) }}
                                    @else
                                    0
                                    @endif
                                </strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-2 mb-2">
                                <small class="text-muted d-block">Rules per Component</small>
                                <strong>
                                    @if($stats['components_count'] > 0)
                                    {{ number_format($stats['rules_count'] / $stats['components_count'], 1) }}
                                    @else
                                    0
                                    @endif
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Trends (if available) -->
@if($monthlyTrends->count() > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Monthly Trends (Last 6 Months)</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th class="text-center">Quotes</th>
                                <th class="text-end">Revenue</th>
                                <th class="text-center">Avg. Value</th>
                                <th class="text-center">Trend</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($monthlyTrends->reverse() as $trend)
                            <tr>
                                <td>{{ date('F Y', mktime(0, 0, 0, $trend->month, 1, $trend->year)) }}</td>
                                <td class="text-center">
                                    <span class="badge bg-info">{{ $trend->quote_count }}</span>
                                </td>
                                <td class="text-end">
                                    <strong>€{{ number_format($trend->monthly_revenue, 2) }}</strong>
                                </td>
                                <td class="text-center">
                                    €{{ number_format($trend->monthly_revenue / $trend->quote_count, 2) }}
                                </td>
                                <td class="text-center">
                                    @if($trend->quote_count > 0)
                                    <i class="fas fa-arrow-up text-success"></i>
                                    @else
                                    <i class="fas fa-minus text-muted"></i>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('styles')
<style>
.card {
    transition: transform 0.2s;
}
.card:hover {
    transform: translateY(-2px);
}
.border-start-primary { border-left: 4px solid #4e73df !important; }
.border-start-success { border-left: 4px solid #1cc88a !important; }
.border-start-info { border-left: 4px solid #36b9cc !important; }
.border-start-warning { border-left: 4px solid #f6c23e !important; }
.border-start-secondary { border-left: 4px solid #858796 !important; }
.border-start-dark { border-left: 4px solid #5a5c69 !important; }
</style>
@endpush