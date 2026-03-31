@extends('layouts.admin')

@section('title', 'Quote ' . $quote->quote_number . ' - MK Gilze Africa')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Quote: {{ $quote->quote_number }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.quotes.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Quotes
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- Quote Header -->
        <div class="card shadow mb-4">
            <div class="card-header bg-success text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-file-invoice me-2"></i>Quote Details</h5>
                    <span class="badge bg-light text-dark fs-6">{{ strtoupper($quote->status) }}</span>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Customer Information:</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="40%">Name:</th>
                                <td>{{ $quote->customer_name }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $quote->customer_email }}</td>
                            </tr>
                            @if($quote->customer_company)
                            <tr>
                                <th>Company:</th>
                                <td>{{ $quote->customer_company }}</td>
                            </tr>
                            @endif
                            @if($quote->customer_phone)
                            <tr>
                                <th>Phone:</th>
                                <td>{{ $quote->customer_phone }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Quote Information:</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="50%">Quote Number:</th>
                                <td><strong>{{ $quote->quote_number }}</strong></td>
                            </tr>
                            <tr>
                                <th>Created:</th>
                                <td>{{ $quote->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Machine:</th>
                                <td>{{ $quote->machine->display_name }}</td>
                            </tr>
                            <tr>
                                <th>Total Installation:</th>
                                <td>{{ $quote->total_installation_time }} hours</td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($quote->notes)
                <div class="mt-3">
                    <h6>Customer Notes:</h6>
                    <div class="alert alert-info">
                        {{ $quote->notes }}
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Configuration Details -->
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-cogs me-2"></i>Configuration Details</h5>
            </div>
            <div class="card-body">
                <!-- Base Machine -->
                <div class="mb-4">
                    <h6>Base Machine:</h6>
                    <div class="card bg-light">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h6 class="mb-1">{{ $quote->machine->display_name }}</h6>
                                    <p class="small text-muted mb-1">{{ $quote->machine->description }}</p>
                                    <small class="text-muted">Model: {{ $quote->machine->name }}</small>
                                </div>
                                <div class="col-md-4 text-end">
                                    <strong class="text-primary fs-5">€{{ number_format($quote->machine->base_price, 2) }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Selected Components -->
                <h6>Selected Components ({{ $quote->components->count() }}):</h6>
                @foreach($quote->components->groupBy('category.name') as $categoryName => $components)
                <div class="mb-3">
                    <h6 class="text-muted border-bottom pb-1">{{ $categoryName }}</h6>
                    @foreach($components as $component)
                    <div class="card mb-2">
                        <div class="card-body py-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>{{ $component->name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $component->description }}</small>
                                    <br>
                                    <small class="text-muted">
                                        Code: {{ $component->code }} | 
                                        Installation: {{ $component->pivot->installation_time }}h
                                    </small>
                                </div>
                                <div class="col-md-6 text-end">
                                    <strong class="text-primary fs-5">€{{ number_format($component->pivot->unit_price, 2) }}</strong>
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

    <div class="col-md-4">
        <!-- Price Summary -->
        <div class="card shadow mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-calculator me-2"></i>Price Summary</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td>Base Machine:</td>
                            <td class="text-end">€{{ number_format($quote->machine->base_price, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Components ({{ $quote->components->count() }}):</td>
                            <td class="text-end">€{{ number_format($pricing['components_price'], 2) }}</td>
                        </tr>
                        <tr class="border-top">
                            <td><strong>Total Price:</strong></td>
                            <td class="text-end">
                                <strong class="text-success fs-4">€{{ number_format($quote->total_price, 2) }}</strong>
                            </td>
                        </tr>
                    </table>
                </div>

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
            </div>
        </div>

        <!-- Status Management -->
        <div class="card shadow mb-4">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>Status Management</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.quotes.status', $quote) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="status" class="form-label">Update Quote Status:</label>
                        <select class="form-select" id="status" name="status">
                            <option value="draft" {{ $quote->status === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="sent" {{ $quote->status === 'sent' ? 'selected' : '' }}>Sent to Customer</option>
                            <option value="accepted" {{ $quote->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                            <option value="rejected" {{ $quote->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-warning w-100">
                        <i class="fas fa-sync me-2"></i>Update Status
                    </button>
                </form>
            </div>
        </div>

        <!-- Actions -->
        <div class="card shadow">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-tools me-2"></i>Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.quotes.export-pdf', $quote) }}" class="btn btn-success" target="_blank">
                        <i class="fas fa-download me-2"></i>Download PDF
                    </a>
                    <a href="{{ route('configurator.show', $quote->machine_id) }}" class="btn btn-outline-primary">
                        <i class="fas fa-cog me-2"></i>Recreate Configuration
                    </a>
                    <form action="{{ route('admin.quotes.destroy', $quote) }}" method="POST" class="d-grid">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this quote?')">
                            <i class="fas fa-trash me-2"></i>Delete Quote
                        </button>
                    </form>
                </div>

                <!-- Quick Stats -->
                <div class="mt-4 pt-3 border-top">
                    <h6 class="text-muted">Quick Stats:</h6>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border rounded p-2">
                                <small class="text-muted d-block">Components</small>
                                <strong>{{ $quote->components->count() }}</strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-2">
                                <small class="text-muted d-block">Installation</small>
                                <strong>{{ $quote->total_installation_time }}h</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Technical Specifications -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0"><i class="fas fa-list-alt me-2"></i>Technical Specifications</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Base Machine Specifications:</h6>
                        @if($quote->machine->specifications)
                        <ul class="list-unstyled">
                            @foreach($quote->machine->specifications as $key => $value)
                            <li><strong>{{ $key }}:</strong> {{ $value }}</li>
                            @endforeach
                        </ul>
                        @else
                        <p class="text-muted">No specifications available.</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h6>Selected Components Summary:</h6>
                        <ul class="list-unstyled">
                            @foreach($quote->components->groupBy('category.name') as $categoryName => $components)
                            <li>
                                <strong>{{ $categoryName }}:</strong>
                                <ul>
                                    @foreach($components as $component)
                                    <li>{{ $component->name }} ({{ $component->code }})</li>
                                    @endforeach
                                </ul>
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