@extends('layouts.app')

@section('title', 'Compare Machines - MK Gilze Africa')

@section('content')
<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('configurator.index') }}">Configurator</a></li>
                <li class="breadcrumb-item active">Compare Machines</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-12 text-center mb-4">
        <h1>Compare Machines</h1>
        <p class="lead">Side-by-side comparison to help you choose the right machine</p>
    </div>
</div>

<!-- Machine Selection -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Machine 1</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="machine1_id" class="form-label">Select Machine</label>
                    <select class="form-select" id="machine1_id" name="machine1_id">
                        <option value="">Choose a machine...</option>
                        @foreach($machines as $machine)
                        <option value="{{ $machine->id }}">
                            {{ $machine->display_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div id="machine1-info" class="machine-info">
                    <!-- Machine 1 details will appear here -->
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Machine 2</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="machine2_id" class="form-label">Select Machine</label>
                    <select class="form-select" id="machine2_id" name="machine2_id">
                        <option value="">Choose a machine...</option>
                        @foreach($machines as $machine)
                        <option value="{{ $machine->id }}">
                            {{ $machine->display_name }} (€{{ number_format($machine->base_price, 2) }})
                        </option>
                        @endforeach
                    </select>
                </div>
                <div id="machine2-info" class="machine-info">
                    <!-- Machine 2 details will appear here -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Comparison Results -->
<div class="row">
    <div class="col-12">
        <div class="card shadow" id="comparison-results" style="display: none;">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-balance-scale me-2"></i>Machine Comparison</h5>
            </div>
            <div class="card-body">
                <div id="comparison-content">
                    <!-- Comparison results will be displayed here -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="row mt-4">
    <div class="col-12 text-center">
        <button id="compare-btn" class="btn btn-primary btn-lg">
            <i class="fas fa-balance-scale me-2"></i>Compare Machines
        </button>
        <a href="{{ route('configurator.index') }}" class="btn btn-secondary btn-lg ms-2">
            <i class="fas fa-arrow-left me-2"></i>Back to Configurator
        </a>
    </div>
</div>
@endsection

@push('styles')
<style>
.machine-info {
    min-height: 100px;
}

.comparison-table th {
    background-color: #f8f9fa;
    font-weight: 600;
}

.specs-table td {
    padding: 8px 12px;
    border-bottom: 1px solid #dee2e6;
}

.price-difference.positive {
    color: #198754;
    font-weight: bold;
}

.price-difference.negative {
    color: #dc3545;
    font-weight: bold;
}

.feature-badge {
    font-size: 0.8em;
}

.machine-card {
    transition: transform 0.2s;
}

.machine-card:hover {
    transform: translateY(-2px);
}
</style>
@endpush

@push('scripts')
<script>
// Global variables to store machine data
let machine1Data = null;
let machine2Data = null;

$(document).ready(function() {
    console.log('Comparison page loaded');

    // Load machine details when selected
    $('#machine1_id, #machine2_id').change(function() {
        const machineId = $(this).val();
        const isMachine1 = $(this).attr('id') === 'machine1_id';
        
        console.log('Machine selected:', machineId, 'isMachine1:', isMachine1);
        
        if (machineId) {
            loadMachineDetails(machineId, isMachine1);
        } else {
            clearMachineDetails(isMachine1);
            updateCompareButton();
        }
    });

    // Compare button click handler
    $('#compare-btn').on('click', function() {
        console.log('Compare button clicked');
        console.log('Machine 1 data:', machine1Data);
        console.log('Machine 2 data:', machine2Data);
        compareMachines();
    });

    // Update compare button state
    function updateCompareButton() {
        const machine1Id = $('#machine1_id').val();
        const machine2Id = $('#machine2_id').val();
        const canCompare = machine1Id && machine2Id && machine1Id !== machine2Id;
        
        console.log('Update compare button - canCompare:', canCompare);
        
        $('#compare-btn').prop('disabled', !canCompare);
    }

    function loadMachineDetails(machineId, isMachine1) {
        const infoDiv = isMachine1 ? '#machine1-info' : '#machine2-info';
        
        console.log('Loading details for machine:', machineId);
        
        $(infoDiv).html('<div class="text-center py-3"><i class="fas fa-spinner fa-spin me-2"></i>Loading machine details...</div>');

        $.ajax({
            url: '/configurator/machine-details/' + machineId,
            method: 'GET',
            success: function(response) {
                console.log('Machine details loaded successfully:', response);
                if (response.error) {
                    $(infoDiv).html(`<div class="alert alert-danger">${response.error}</div>`);
                } else {
                    displayMachineDetails(response, infoDiv, isMachine1);
                }
                updateCompareButton();
            },
            error: function(xhr) {
                console.error('Error loading machine details:', xhr);
                let errorMessage = 'Failed to load machine details. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMessage = xhr.responseJSON.error;
                } else if (xhr.status === 404) {
                    errorMessage = 'Machine not found. Please select a different machine.';
                }
                $(infoDiv).html(`<div class="alert alert-danger">${errorMessage}</div>`);
            }
        });
    }

    function displayMachineDetails(machineData, infoDiv, isMachine1) {
        console.log('Displaying machine details:', machineData);
        
        // Store machine data
        if (isMachine1) {
            machine1Data = machineData;
        } else {
            machine2Data = machineData;
        }

        const infoHTML = `
            <div class="machine-card">
                <h6 class="text-primary">${machineData.display_name}</h6>
                <p class="small text-muted mb-2">${machineData.description}</p>
                
                
                
            </div>
        `;

        $(infoDiv).html(infoHTML);
        console.log('Machine details displayed for:', machineData.display_name);
    }

    function clearMachineDetails(isMachine1) {
        const infoDiv = isMachine1 ? '#machine1-info' : '#machine2-info';
        $(infoDiv).empty();
        
        if (isMachine1) {
            machine1Data = null;
        } else {
            machine2Data = null;
        }
        
        console.log('Cleared machine details for:', isMachine1 ? 'Machine 1' : 'Machine 2');
    }
});

function compareMachines() {
    console.log('compareMachines function called');
    console.log('Machine 1:', machine1Data);
    console.log('Machine 2:', machine2Data);
    
    if (!machine1Data || !machine2Data) {
        alert('Please select both machines to compare.');
        return;
    }

    if (machine1Data.id === machine2Data.id) {
        alert('Please select two different machines to compare.');
        return;
    }

    console.log('Starting comparison...');
    $('#compare-btn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Comparing...');

    // Show comparison immediately
    displayComparisonResults();
    
    // Re-enable button after a short delay
    setTimeout(function() {
        $('#compare-btn').prop('disabled', false).html('<i class="fas fa-balance-scale me-2"></i>Compare Machines');
    }, 1000);
}

function displayComparisonResults() {
    console.log('Displaying comparison results');
    
    const container = $('#comparison-content');
    const resultsDiv = $('#comparison-results');
    
    const priceDifference = machine1Data.base_price - machine2Data.base_price;
    const componentsDifference = machine1Data.components_count - machine2Data.components_count;
    const categoriesDifference = machine1Data.categories_count - machine2Data.categories_count;
    
    console.log('Price difference:', priceDifference);
    console.log('Components difference:', componentsDifference);
    
    const comparisonHTML = `
        <div class="row">
            <!-- Machine 1 -->
            <div class="col-md-6">
                <div class="card border-primary h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-cog me-2"></i>${machine1Data.display_name}</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h3 class="text-primary">€${machine1Data.base_price.toFixed(2)}</h3>
                            <span class="badge bg-info">Base Price</span>
                        </div>
                        
                        <div class="mb-3">
                            <p class="text-muted">${machine1Data.description}</p>
                        </div>
                        
                        <div class="mb-3">
                            <h6><i class="fas fa-puzzle-piece me-2"></i>Components & Categories</h6>
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="border rounded p-2">
                                        <div class="h5 text-primary mb-0">${machine1Data.components_count}</div>
                                        <small class="text-muted">Components</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border rounded p-2">
                                        <div class="h5 text-success mb-0">${machine1Data.categories_count}</div>
                                        <small class="text-muted">Categories</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        ${machine1Data.specifications ? `
                        <div class="mb-3">
                            <h6><i class="fas fa-list-alt me-2"></i>Key Specifications</h6>
                            <div class="small">
                                ${Object.entries(machine1Data.specifications).slice(0, 3).map(([key, value]) => 
                                    `<div class="d-flex justify-content-between border-bottom py-1">
                                        <span class="text-muted">${key}:</span>
                                        <strong>${value}</strong>
                                    </div>`
                                ).join('')}
                            </div>
                        </div>
                        ` : ''}
                        
                        <div class="mt-4">
                            <button class="btn btn-primary w-100" onclick="configureMachine(${machine1Data.id})">
                                <i class="fas fa-cog me-2"></i>Configure ${machine1Data.display_name}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Machine 2 -->
            <div class="col-md-6">
                <div class="card border-success h-100">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-cog me-2"></i>${machine2Data.display_name}</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h3 class="text-success">€${machine2Data.base_price.toFixed(2)}</h3>
                            <span class="badge bg-info">Base Price</span>
                        </div>
                        
                        <div class="mb-3">
                            <p class="text-muted">${machine2Data.description}</p>
                        </div>
                        
                        <div class="mb-3">
                            <h6><i class="fas fa-puzzle-piece me-2"></i>Components & Categories</h6>
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="border rounded p-2">
                                        <div class="h5 text-primary mb-0">${machine2Data.components_count}</div>
                                        <small class="text-muted">Components</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border rounded p-2">
                                        <div class="h5 text-success mb-0">${machine2Data.categories_count}</div>
                                        <small class="text-muted">Categories</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        ${machine2Data.specifications ? `
                        <div class="mb-3">
                            <h6><i class="fas fa-list-alt me-2"></i>Key Specifications</h6>
                            <div class="small">
                                ${Object.entries(machine2Data.specifications).slice(0, 3).map(([key, value]) => 
                                    `<div class="d-flex justify-content-between border-bottom py-1">
                                        <span class="text-muted">${key}:</span>
                                        <strong>${value}</strong>
                                    </div>`
                                ).join('')}
                            </div>
                        </div>
                        ` : ''}
                        
                        <div class="mt-4">
                            <button class="btn btn-success w-100" onclick="configureMachine(${machine2Data.id})">
                                <i class="fas fa-cog me-2"></i>Configure ${machine2Data.display_name}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Comparison Summary -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-warning">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Comparison Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-3">
                                    <h6>Price Difference</h6>
                                    <h4 class="${priceDifference > 0 ? 'text-danger' : priceDifference < 0 ? 'text-success' : 'text-muted'}">
                                        ${priceDifference > 0 ? '+' : ''}€${Math.abs(priceDifference).toFixed(2)}
                                    </h4>
                                    <small class="text-muted">
                                        ${priceDifference > 0 ? machine1Data.display_name + ' is more expensive' : 
                                          priceDifference < 0 ? machine2Data.display_name + ' is more expensive' : 
                                          'Same base price'}
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-3">
                                    <h6>Components Available</h6>
                                    <h4 class="${componentsDifference > 0 ? 'text-success' : componentsDifference < 0 ? 'text-warning' : 'text-muted'}">
                                        ${machine1Data.components_count} vs ${machine2Data.components_count}
                                    </h4>
                                    <small class="text-muted">
                                        ${componentsDifference > 0 ? machine1Data.display_name + ' has more options' :
                                          componentsDifference < 0 ? machine2Data.display_name + ' has more options' :
                                          'Same number of components'}
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-3">
                                    <h6>Recommendation</h6>
                                    <h4 class="text-info">
                                        ${getRecommendation(priceDifference, componentsDifference)}
                                    </h4>
                                    <small class="text-muted">
                                        Based on price and features
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    container.html(comparisonHTML);
    resultsDiv.show();
    
    console.log('Comparison results displayed');
    
    // Scroll to results
    $('html, body').animate({
        scrollTop: resultsDiv.offset().top - 100
    }, 1000);
}

function getRecommendation(priceDiff, componentsDiff) {
    if (priceDiff < 0 && componentsDiff > 0) {
        return 'Best Value ✓';
    } else if (priceDiff > 0 && componentsDiff > 0) {
        return 'Premium Choice';
    } else if (priceDiff < 0 && componentsDiff < 0) {
        return 'Budget Option';
    } else if (priceDiff < 0 && componentsDiff >= 0) {
        return 'Great Deal';
    } else {
        return 'Compare Features';
    }
}

function configureMachine(machineId) {
    console.log('Configuring machine:', machineId);
    window.location.href = '/configurator/machine/' + machineId;
}
</script>
@endpush