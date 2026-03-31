@extends('layouts.app')

@section('title', "Quote {$quote->quote_number} - MK Gilze Africa")

@section('content')
<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('configurator.index') }}">Machines</a></li>
                <li class="breadcrumb-item"><a href="{{ route('configurator.show', $quote->machine_id) }}">Configuration</a></li>
                <li class="breadcrumb-item active">Quote {{ $quote->quote_number }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Quote Header -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-file-invoice me-2"></i>Quote: {{ $quote->quote_number }}</h4>
                    <span class="badge bg-light text-dark fs-6">{{ strtoupper($quote->status) }}</span>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Customer Information:</h6>
                        <p class="mb-1"><strong>{{ $quote->customer_name }}</strong></p>
                        <p class="mb-1">{{ $quote->customer_email }}</p>
                        @if($quote->customer_company)
                        <p class="mb-1">{{ $quote->customer_company }}</p>
                        @endif
                        @if($quote->customer_phone)
                        <p class="mb-1">{{ $quote->customer_phone }}</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h6>Quote Details:</h6>
                        <p class="mb-1"><strong>Created:</strong> {{ $quote->created_at->format('M d, Y') }}</p>
                        <p class="mb-1"><strong>Machine:</strong> {{ $quote->machine->display_name }}</p>
                        <p class="mb-1"><strong>Installation Time:</strong> {{ $quote->total_installation_time }} hours</p>
                    </div>
                </div>
                
                @if($quote->notes)
                <div class="mt-3">
                    <h6>Additional Notes:</h6>
                    <p class="mb-0">{{ $quote->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Configuration Details -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-cogs me-2"></i>Configuration Details</h5>
            </div>
            <div class="card-body">
                <!-- Machine Information -->
                <div class="mb-4">
                    <h6>Base Machine:</h6>
                    <div class="card bg-light">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h6 class="mb-1">{{ $quote->machine->display_name }}</h6>
                                    <p class="small text-muted mb-1">{{ $quote->machine->description }}</p>
                                </div>
                                <div class="col-md-4 text-end">
                                    <strong class="text-primary">€{{ number_format($quote->machine->base_price, 2) }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Selected Components -->
                <h6>Selected Components:</h6>
                @foreach($quote->components->groupBy('category.name') as $categoryName => $components)
                <div class="mb-3">
                    <h6 class="text-muted">{{ $categoryName }}</h6>
                    @foreach($components as $component)
                    <div class="card mb-2">
                        <div class="card-body py-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>{{ $component->name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $component->description }}</small>
                                    <br>
                                    <small class="text-muted">Code: {{ $component->code }} | Installation: {{ $component->pivot->installation_time }}h</small>
                                </div>
                                <div class="col-md-6 text-end">
                                    <strong class="text-primary">€{{ number_format($component->pivot->unit_price, 2) }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Price Summary Sidebar -->
    <div class="col-lg-4">
        <div class="card price-breakdown">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Price Summary</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Base Machine:</span>
                        <span>€{{ number_format($quote->machine->base_price, 2) }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Components ({{ $quote->components->count() }}):</span>
                        <span>€{{ number_format($pricing['components_price'], 2) }}</span>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total Price:</span>
                        <span class="text-success">€{{ number_format($quote->total_price, 2) }}</span>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="mt-4">
                    <div class="d-flex justify-content-between small text-muted mb-1">
                        <span>Total Installation Time:</span>
                        <span>{{ $quote->total_installation_time }} hours</span>
                    </div>
                    <div class="d-flex justify-content-between small text-muted mb-1">
                        <span>Components Selected:</span>
                        <span>{{ $quote->components->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between small text-muted">
                        <span>Quote Valid Until:</span>
                        <span>{{ $quote->created_at->addDays(30)->format('M d, Y') }}</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-4">
                    <div class="d-grid gap-2">
                        <a href="{{ route('configurator.export-pdf', $quote->id) }}" class="btn btn-success" target="_blank">
                            <i class="fas fa-download me-2"></i>Download PDF Quote
                        </a>
                        <a href="{{ route('configurator.show', $quote->machine_id) }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-2"></i>Modify Configuration
                        </a>
                        <a href="{{ route('configurator.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-plus me-2"></i>Create New Configuration
                        </a>
                    </div>
                </div>

                <!-- Quote Notes -->
                <div class="mt-4">
                    <div class="alert alert-info">
                        <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Quote Information</h6>
                        <p class="small mb-0">
                            This quote is valid for 30 days. Prices include equipment but exclude installation labor, 
                            transportation, and any required site preparations.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Technical Specifications -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-list-alt me-2"></i>Technical Specifications</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Base Machine Specifications:</h6>
                        <ul class="list-unstyled">
                            @foreach($quote->machine->specifications as $key => $value)
                            <li><strong>{{ $key }}:</strong> {{ $value }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Selected Components:</h6>
                        <ul class="list-unstyled">
                            @foreach($quote->components as $component)
                            <li>
                                <strong>{{ $component->name }}</strong> ({{ $component->code }})
                                <br>
                                <small class="text-muted">{{ $component->description }}</small>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection