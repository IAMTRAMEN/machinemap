@extends('layouts.admin')

@section('title', $configuration->configuration_number . ' - MK Gilze Africa')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Configuration: {{ $configuration->configuration_number }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.configurations.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Configurations
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Configuration Details -->
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Configuration Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Configuration Number:</th>
                                <td><code>{{ $configuration->configuration_number }}</code></td>
                            </tr>
                            <tr>
                                <th>Machine:</th>
                                <td>{{ $configuration->machine->display_name }}</td>
                            </tr>
                            <tr>
                                <th>Total Price:</th>
                                <td class="h4 text-success">€{{ number_format($configuration->total_price, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    <span class="badge bg-{{ $configuration->status === 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($configuration->status) }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Created:</th>
                                <td>{{ $configuration->created_at->format('M d, Y g:i A') }}</td>
                            </tr>
                            <tr>
                                <th>Last Updated:</th>
                                <td>{{ $configuration->updated_at->format('M d, Y g:i A') }}</td>
                            </tr>
                            <tr>
                                <th>Components:</th>
                                <td>{{ $configuration->components_count }} selected</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="card shadow mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Customer Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Name:</th>
                                <td>{{ $configuration->customer_name }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $configuration->customer_email }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Company:</th>
                                <td>{{ $configuration->customer_company ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Phone:</th>
                                <td>{{ $configuration->customer_phone ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                @if($configuration->notes)
                <div class="mt-3">
                    <strong>Notes:</strong>
                    <p class="mb-0">{{ $configuration->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Selected Components -->
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Selected Components ({{ $configuration->components_count }})</h5>
            </div>
            <div class="card-body">
                @if($components->count() > 0)
                    @foreach($components->groupBy('category.name') as $categoryName => $categoryComponents)
                    <div class="mb-4">
                        <h6 class="text-muted border-bottom pb-2">{{ $categoryName }}</h6>
                        <div class="row">
                            @foreach($categoryComponents as $component)
                            <div class="col-md-6 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body py-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">{{ $component->name }}</h6>
                                                <p class="small text-muted mb-1">{{ $component->description }}</p>
                                                <small class="text-muted">Code: {{ $component->code }}</small>
                                            </div>
                                            <div class="text-end">
                                                <div class="text-primary fw-bold">€{{ number_format($component->price, 2) }}</div>
                                                <small class="text-muted">{{ $component->installation_time }}h</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                @else
                <div class="text-center py-4">
                    <i class="fas fa-puzzle-piece fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No components selected</h5>
                    <p class="text-muted">This configuration doesn't have any components selected.</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Pricing Summary -->
        <div class="card shadow mb-4">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">Pricing Summary</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td>Base Machine:</td>
                        <td class="text-end">€{{ number_format($pricing['base_price'], 2) }}</td>
                    </tr>
                    <tr>
                        <td>Components ({{ $configuration->components_count }}):</td>
                        <td class="text-end">€{{ number_format($pricing['components_price'], 2) }}</td>
                    </tr>
                    <tr class="table-active">
                        <td><strong>Total Price:</strong></td>
                        <td class="text-end"><strong>€{{ number_format($pricing['total'], 2) }}</strong></td>
                    </tr>
                </table>
                
                <div class="mt-3">
                    <div class="d-flex justify-content-between small text-muted">
                        <span>Installation Time:</span>
                        <span>{{ $pricing['installation_time'] }} hours</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Machine Specifications -->
        <div class="card shadow mb-4">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">Machine Specifications</h5>
            </div>
            <div class="card-body">
                <h6>{{ $configuration->machine->display_name }}</h6>
                <p class="small text-muted">{{ $configuration->machine->description }}</p>
                
                @if($configuration->machine->specifications)
                <div class="mt-3">
                    <strong>Key Specifications:</strong>
                    <div class="small mt-2">
                        @foreach($configuration->machine->specifications as $key => $value)
                        <div class="d-flex justify-content-between border-bottom py-1">
                            <span class="text-muted">{{ $key }}:</span>
                            <strong>{{ $value }}</strong>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Actions -->
        <div class="card shadow">
            <div class="card-header bg-light">
                <h5 class="mb-0">Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('configurator.load', $configuration->configuration_number) }}" 
                       class="btn btn-primary" target="_blank">
                        <i class="fas fa-external-link-alt me-2"></i>Open in Configurator
                    </a>
                    <a href="{{ route('configurator.export-pdf', $configuration->id) }}" 
                       class="btn btn-success">
                        <i class="fas fa-download me-2"></i>Export as PDF
                    </a>
                    <button class="btn btn-outline-info" onclick="copyConfigurationNumber('{{ $configuration->configuration_number }}')">
                        <i class="fas fa-copy me-2"></i>Copy Config Number
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function copyConfigurationNumber(configNumber) {
    navigator.clipboard.writeText(configNumber).then(function() {
        // Show success message
        const alert = $(`
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>Configuration number copied to clipboard!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
        $('.container-fluid').prepend(alert);
        
        setTimeout(() => {
            alert.alert('close');
        }, 3000);
    }).catch(function() {
        // Show error message
        const alert = $(`
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>Failed to copy configuration number.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
        $('.container-fluid').prepend(alert);
    });
}
</script>
@endpush