@extends('layouts.app')

@section('title', "Configure {$machine->display_name} - MK Gilze Africa")

@section('content')
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('configurator.index') }}">Machines</a></li>
                    <li class="breadcrumb-item active">{{ $machine->display_name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Machine Header -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h2 class="card-title">{{ $machine->display_name }}</h2>
                            <p class="card-text">{{ $machine->description }}</p>

                            @if ($machine->specifications)
                                <div class="mt-3">
                                    <h6>Specifications:</h6>
                                    <div class="row">
                                        @foreach ($machine->specifications as $key => $value)
                                            <div class="col-sm-6">
                                                <small><strong>{{ $key }}:</strong> {{ $value }}</small>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="h3 text-primary">€{{ number_format($machine->base_price, 2) }}</div>
                            <span class="badge bg-secondary">Base Machine</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loading Notification for Saved Configurations -->
            @if (isset($configuration) && $configuration)
                <div class="alert alert-info alert-dismissible fade show mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle fa-2x me-3"></i>
                        <div class="flex-grow-1">
                            <h5 class="alert-heading mb-1">Loaded Saved Configuration</h5>
                            <p class="mb-1">Configuration: <strong>{{ $configuration->configuration_number }}</strong></p>
                            <p class="mb-0">Customer: <strong>{{ $configuration->customer_name }}</strong> | Machine:
                                <strong>{{ $configuration->machine->display_name }}</strong></p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            @endif

            <!-- Compatibility Alerts -->
            <div id="compatibility-alerts" class="mb-4"></div>

            <!-- Popular Components Section -->
            @if ($popularComponents->count() > 0)
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-fire me-2"></i>Recommended Components</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">These components work well with the {{ $machine->display_name }}:</p>
                        <div class="row">
                            @foreach ($popularComponents as $component)
                                <div class="col-md-4 mb-3">
                                    <div class="card popular-component-card" data-component-id="{{ $component->id }}">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $component->name }}</h6>
                                            <p class="card-text small text-muted mb-2">
                                                {{ Str::limit($component->description, 60) }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span
                                                    class="text-primary fw-bold">€{{ number_format($component->price, 2) }}</span>
                                            </div>
                                            <button class="btn btn-sm btn-outline-primary w-100 mt-2 add-popular-component"
                                                data-component-id="{{ $component->id }}">
                                                <i class="fas fa-plus me-1"></i>Add to Configuration
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Components Selection -->
            <form id="configurator-form" method="POST" action="{{ route('configurator.quote') }}">
                @csrf
                <input type="hidden" name="machine_id" value="{{ $machine->id }}">

                @foreach ($categories as $category)
                    @if ($category->components->count() > 0)
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">
                                    <i class="fas fa-folder me-2"></i>{{ $category->name }}
                                </h5>
                                @if ($category->description)
                                    <p class="mb-0 small text-muted">{{ $category->description }}</p>
                                @endif
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($category->components as $component)
                                        <div class="col-lg-6 mb-3">
                                            <div class="card component-card h-100"
                                                data-component-id="{{ $component->id }}">
                                                <div class="card-body">
                                                    <div class="form-check">
                                                        <input class="form-check-input component-checkbox" type="checkbox"
                                                            name="components[]" value="{{ $component->id }}"
                                                            id="component-{{ $component->id }}">
                                                        <label class="form-check-label w-100"
                                                            for="component-{{ $component->id }}">
                                                            <h6 class="card-title mb-1">{{ $component->name }}</h6>
                                                            <p class="card-text small text-muted mb-1">
                                                                {{ $component->description }}</p>
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <span
                                                                    class="text-primary fw-bold">€{{ number_format($component->price, 2) }}</span>
                                                                <small class="text-muted">
                                                                    <i
                                                                        class="fas fa-clock me-1"></i>{{ $component->installation_time }}h
                                                                </small>
                                                            </div>
                                                            <small class="text-muted">Code: {{ $component->code }}</small>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

                <!-- Customer Information -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i>Customer Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="customer_name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="customer_email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="customer_email" name="customer_email"
                                    required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="customer_company" class="form-label">Company</label>
                                <input type="text" class="form-control" id="customer_company"
                                    name="customer_company">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="customer_phone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="customer_phone" name="customer_phone">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Additional Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"
                                placeholder="Any special requirements or notes..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="d-flex justify-content-between">
                    <a href="{{ route('configurator.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Machines
                    </a>
                    <div>
                        <button type="button" id="save-configuration-btn" class="btn btn-info me-2">
                            <i class="fas fa-save me-2"></i>
                            {{ isset($configuration) ? 'Save as New Configuration' : 'Save for Later' }}
                        </button>
                        <button type="submit" id="generate-quote-btn" class="btn btn-success">
                            <i class="fas fa-file-pdf me-2"></i>Generate Quote
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Price Breakdown Sidebar -->
        <div class="col-lg-4">
            <div class="card price-breakdown">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-calculator me-2"></i>Price Breakdown</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Base Machine:</span>
                            <span id="base-price">€{{ number_format($machine->base_price, 2) }}</span>
                        </div>

                        <!-- Selected Components List -->
                        <div id="selected-components-breakdown" class="mt-3">
                            <div class="text-center text-muted py-2">
                                <i class="fas fa-puzzle-piece fa-2x mb-2"></i>
                                <p class="small mb-0">No components selected yet</p>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between fw-bold fs-5">
                            <span>Total Price:</span>
                            <span id="total-price">€{{ number_format($machine->base_price, 2) }}</span>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="d-flex justify-content-between small text-muted mb-2">
                            <span>Installation Time:</span>
                            <span id="installation-time">0 hours</span>
                        </div>
                        <div class="d-flex justify-content-between small text-muted mb-3">
                            <span>Selected Components:</span>
                            <span id="components-count">0</span>
                        </div>
                    </div>

                    <!-- Quick Summary -->
                    <div id="configuration-summary" class="mt-3 small text-muted">
                        <em>Select components to see pricing breakdown</em>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .featured-machine {
            border: 2px solid #ffc107;
            transform: scale(1.02);
            transition: transform 0.3s ease;
        }

        .featured-machine:hover {
            transform: scale(1.05);
        }

        .step-number {
            width: 40px;
            height: 40px;
            background: #0d6efd;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-weight: bold;
        }

        .card {
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .component-card {
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .component-card.selected {
            border-color: #0d6efd;
            background-color: #f8f9fa;
        }

        .component-card:hover {
            border-color: #0d6efd;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Price Breakdown Styles */
        .category-breakdown {
            border-left: 3px solid #e9ecef;
            padding-left: 12px;
            margin-bottom: 15px;
        }

        .category-header {
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 6px;
            margin-bottom: 8px;
            font-size: 0.85rem;
        }

        .component-item {
            transition: all 0.3s ease;
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.05), rgba(0, 123, 255, 0.05)) !important;
            border-radius: 6px;
            margin-bottom: 8px;
        }

        .component-item:hover {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(0, 123, 255, 0.1)) !important;
            transform: translateX(4px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .components-total {
            border-top: 3px solid #28a745 !important;
            font-size: 1.1em;
            padding-top: 12px;
            margin-top: 15px;
        }

        .summary-stats {
            border-left: 4px solid #007bff;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef) !important;
            border-radius: 8px;
        }

        .price-breakdown {
            position: sticky;
            top: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Animation for components */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .component-item {
            animation: slideInUp 0.4s ease-out;
        }

        /* Make it responsive */
        @media (max-width: 991.98px) {
            .price-breakdown {
                position: static;
                margin-top: 2rem;
            }
        }

        .quick-search:hover {
            color: var(--primary) !important;
            text-decoration: underline !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Global variables
        let selectedComponents = [];
        let isLoadedConfiguration = {{ isset($configuration) && $configuration ? 'true' : 'false' }};

        $(document).ready(function() {
            console.log('Configurator page loaded');

            // Handle saved configuration loading
            @if (isset($configuration) && $configuration)
                loadSavedConfiguration();
            @endif

            // Component selection toggle
            $('.component-card').click(function(e) {
                if (!$(e.target).is('input')) {
                    const componentId = $(this).data('component-id');
                    const checkbox = $(`#component-${componentId}`);

                    checkbox.prop('checked', !checkbox.prop('checked'));

                    if (checkbox.prop('checked')) {
                        $(this).addClass('selected');
                        if (!selectedComponents.includes(componentId)) {
                            selectedComponents.push(componentId);
                        }
                    } else {
                        $(this).removeClass('selected');
                        selectedComponents = selectedComponents.filter(id => id !== componentId);
                    }

                    validateConfiguration();
                }
            });

            // Checkbox change handler
            $('.component-checkbox').change(function() {
                const componentId = $(this).val();
                const card = $(`.component-card[data-component-id="${componentId}"]`);

                if ($(this).prop('checked')) {
                    card.addClass('selected');
                    if (!selectedComponents.includes(parseInt(componentId))) {
                        selectedComponents.push(parseInt(componentId));
                    }
                } else {
                    card.removeClass('selected');
                    selectedComponents = selectedComponents.filter(id => id !== parseInt(componentId));
                }

                validateConfiguration();
            });

            // Popular components add button
            $('.add-popular-component').click(function() {
                const componentId = $(this).data('component-id');
                const checkbox = $(`#component-${componentId}`);

                if (!checkbox.prop('checked')) {
                    checkbox.prop('checked', true);
                    checkbox.closest('.component-card').addClass('selected');
                    if (!selectedComponents.includes(componentId)) {
                        selectedComponents.push(componentId);
                    }
                    validateConfiguration();

                    // Show feedback
                    showNotification('Component added to configuration', 'success');
                }
            });

            // Save configuration button
            $('#save-configuration-btn').click(function(e) {
                e.preventDefault();
                saveConfiguration();
            });

            // Initial validation
            validateConfiguration();
        });

        /**
         * Load a saved configuration and pre-select components
         */
        function loadSavedConfiguration() {
            console.log('Loading saved configuration...');

            const savedComponents = @json($configuration->selected_components ?? []);
            const configNumber = '{{ $configuration->configuration_number ?? '' }}';

            console.log('Saved components to load:', savedComponents);

            // Check each component from the saved configuration
            savedComponents.forEach(componentId => {
                const checkbox = $(`#component-${componentId}`);
                if (checkbox.length) {
                    checkbox.prop('checked', true);
                    const card = checkbox.closest('.component-card');
                    card.addClass('selected');
                    if (!selectedComponents.includes(componentId)) {
                        selectedComponents.push(componentId);
                    }
                }
            });

            // Pre-fill customer information
            $('#customer_name').val('{{ $configuration->customer_name ?? '' }}');
            $('#customer_email').val('{{ $configuration->customer_email ?? '' }}');
            $('#customer_company').val('{{ $configuration->customer_company ?? '' }}');
            $('#customer_phone').val('{{ $configuration->customer_phone ?? '' }}');
            $('#notes').val('{{ $configuration->notes ?? '' }}');

            // Update the pricing and validation
            setTimeout(() => {
                validateConfiguration();
            }, 500);
        }

        /**
         * Validate configuration and update pricing
         */
        function validateConfiguration() {
            const machineId = {{ $machine->id }};

            console.log('Validating with components:', selectedComponents);

            $.ajax({
                url: '{{ route('configurator.validate') }}',
                method: 'POST',
                data: {
                    machine_id: machineId,
                    components: selectedComponents,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('Backend response:', response);
                    updatePriceBreakdown(response.pricing);
                    updateCompatibilityAlerts(response.messages);
                    updateGenerateButton(response.can_proceed);
                },
                error: function(xhr) {
                    console.error('Validation failed:', xhr);
                    console.error('Response text:', xhr.responseText);
                }
            });
        }

        /**
         * Update price breakdown with live component details
         */
        function updatePriceBreakdown(pricing) {
            console.log('Updating price breakdown with:', pricing);

            // Helper to format price with thousand separators and 2 decimals
            const formatPrice = (value) => {
                let num = parseFloat(value.toString().replace(',', '.'));
                return new Intl.NumberFormat('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(num);
            };

            // Update basic prices
            $('#base-price').text('€' + formatPrice(pricing.base_price));
            $('#components-price').text('€' + formatPrice(pricing.components_price));
            $('#total-price').text('€' + formatPrice(pricing.total));

            // Update other details
            $('#installation-time').text(pricing.installation_time + ' hours');
            $('#components-count').text(pricing.components.length);

            // Update the detailed components breakdown
            updateSelectedComponentsBreakdown(pricing.components);
        }


        /**
         * Update the selected components breakdown in the sidebar
         */
        function updateSelectedComponentsBreakdown(components) {
            console.log('Updating components breakdown with:', components);

            const breakdownContainer = $('#selected-components-breakdown');
            const summaryContainer = $('#configuration-summary');

            breakdownContainer.empty();
            summaryContainer.empty();

            if (components.length === 0) {
                breakdownContainer.html(`
            <div class="text-center text-muted py-2">
                <i class="fas fa-puzzle-piece fa-2x mb-2"></i>
                <p class="small mb-0">No components selected yet</p>
            </div>
        `);
                summaryContainer.html('<em>Select components to see pricing breakdown</em>');
                return;
            }

            // Create simple component list (no categories for now)
            let breakdownHTML = '';
            let totalComponentsPrice = 0;

            components.forEach(component => {
                // Use the component data as it comes from backend
                const componentName = component.name || 'Component ' + component.id;
                const componentCode = component.code || 'CMP' + component.id;
                const componentPrice = parseFloat(component.price) || 0;

                totalComponentsPrice += componentPrice;

                breakdownHTML += `
            <div class="component-item d-flex justify-content-between align-items-center py-2 px-3 mb-2">
                <div class="component-info flex-grow-1">
                    <div class="component-name small fw-medium text-dark">${componentName}</div>
                    <div class="component-code xsmall text-muted">${componentCode}</div>
                </div>
                <div class="component-price text-success fw-semibold text-nowrap ms-2">
                    €${componentPrice.toFixed(2)}
                </div>
            </div>
        `;
            });

            // Add components total
            breakdownHTML += `
        <div class="components-total d-flex justify-content-between border-top pt-3 mt-3">
            <span class="fw-bold">Components Total:</span>
            <span class="fw-bold text-primary">€${totalComponentsPrice.toFixed(2)}</span>
        </div>
    `;

            breakdownContainer.html(breakdownHTML);

            // Update configuration summary
            summaryContainer.html(`
        <div class="summary-stats p-3">
            <h6 class="mb-2"><i class="fas fa-chart-bar me-1"></i>Configuration Summary</h6>
            <div class="d-flex justify-content-between mb-1">
                <span>Total Components:</span>
                <span class="fw-semibold">${components.length}</span>
            </div>
            <div class="d-flex justify-content-between mb-1">
                <span>Components Total:</span>
                <span class="fw-semibold text-primary">€${totalComponentsPrice.toFixed(2)}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Avg. Price/Component:</span>
                <span class="fw-semibold">€${(totalComponentsPrice / components.length).toFixed(2)}</span>
            </div>
        </div>
    `);
        }

        function updateCompatibilityAlerts(messages) {
            const alertsContainer = $('#compatibility-alerts');
            alertsContainer.empty();

            messages.forEach(function(message) {
                const alertClass = message.type === 'error' ? 'alert-danger' : 'alert-warning';
                const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>${message.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
                alertsContainer.append(alertHtml);
            });
        }

        function updateGenerateButton(canProceed) {
            const generateBtn = $('#generate-quote-btn');
            generateBtn.prop('disabled', !canProceed);

            if (canProceed) {
                generateBtn.removeClass('btn-secondary').addClass('btn-success');
                generateBtn.html('<i class="fas fa-file-pdf me-2"></i>Generate Quote');
            } else {
                generateBtn.removeClass('btn-success').addClass('btn-secondary');
                generateBtn.html('<i class="fas fa-exclamation-triangle me-2"></i>Fix Issues First');
            }
        }

        /**
         * Save configuration functionality
         */
        function saveConfiguration() {
            // Basic validation
            if (selectedComponents.length === 0) {
                showNotification('Please select at least one component to save the configuration.', 'warning');
                return;
            }

            const customerName = $('#customer_name').val().trim();
            const customerEmail = $('#customer_email').val().trim();

            if (!customerName) {
                showNotification('Please enter customer name.', 'warning');
                $('#customer_name').focus();
                return;
            }

            if (!customerEmail) {
                showNotification('Please enter customer email.', 'warning');
                $('#customer_email').focus();
                return;
            }

            // Show loading state
            const saveBtn = $('#save-configuration-btn');
            const originalText = saveBtn.html();
            saveBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Saving...');

            // Prepare data
            const saveData = {
                machine_id: {{ $machine->id }},
                components: selectedComponents,
                customer_name: customerName,
                customer_email: customerEmail,
                customer_company: $('#customer_company').val().trim(),
                customer_phone: $('#customer_phone').val().trim(),
                notes: $('#notes').val().trim(),
                _token: '{{ csrf_token() }}'
            };

            console.log('Saving configuration:', saveData);

            // AJAX request to save configuration
            $.ajax({
                url: '{{ route('configurator.save') }}',
                method: 'POST',
                data: saveData,
                success: function(response) {
                    console.log('Save response:', response);

                    if (response.success) {
                        showNotification(response.message, 'success');
                        showConfigurationModal(response.configuration_number);
                    } else {
                        showNotification(response.message || 'Failed to save configuration.', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Save configuration error:', error, xhr.responseText);
                    let errorMessage = 'Failed to save configuration. Please try again.';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.status === 422) {
                        // Validation errors
                        const errors = xhr.responseJSON.errors;
                        errorMessage = Object.values(errors).flat().join(', ');
                    }

                    showNotification(errorMessage, 'error');
                },
                complete: function() {
                    // Restore button state
                    saveBtn.prop('disabled', false).html(originalText);
                }
            });
        }

        /**
         * Show configuration saved modal
         */
        function showConfigurationModal(configNumber) {
            const modalHTML = `
        <div class="modal fade" id="configurationSavedModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-check-circle me-2"></i>Configuration Saved
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center py-4">
                        <div class="mb-4">
                            <i class="fas fa-save fa-4x text-success mb-3"></i>
                            <h4 class="text-success">Configuration Saved!</h4>
                        </div>
                        
                        <div class="alert alert-info bg-light border-0">
                            <strong class="d-block mb-2">Your Configuration Number:</strong>
                            <div class="configuration-number display-6 text-primary fw-bold">
                                ${configNumber}
                            </div>
                        </div>
                        
                        <p class="text-muted mb-3">
                            <i class="fas fa-info-circle me-1"></i>
                            Save this number to load your configuration later. You can share it with colleagues or customers.
                        </p>
                        
                        <div class="bg-light rounded p-3 mb-3">
                            <small class="text-muted">
                                <strong>Tip:</strong> You can load this configuration anytime by:
                                <br>1. Going to the Machines page
                                <br>2. Clicking "Load Saved Configuration" 
                                <br>3. Entering: <code>${configNumber}</code>
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Close
                        </button>
                        <button type="button" class="btn btn-primary" onclick="copyConfigurationNumber('${configNumber}')">
                            <i class="fas fa-copy me-2"></i>Copy Number
                        </button>
                        <a href="{{ route('configurator.index') }}" class="btn btn-outline-success">
                            <i class="fas fa-home me-2"></i>Back to Machines
                        </a>
                    </div>
                </div>
            </div>
        </div>
    `;

            // Remove existing modal if any
            $('#configurationSavedModal').remove();

            // Add new modal to body
            $('body').append(modalHTML);

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('configurationSavedModal'));
            modal.show();
        }

        /**
         * Copy configuration number to clipboard
         */
        function copyConfigurationNumber(configNumber) {
            navigator.clipboard.writeText(configNumber).then(function() {
                showNotification('Configuration number copied to clipboard!', 'success');

                // Update button text temporarily
                $('.btn-primary').find('i').removeClass('fa-copy').addClass('fa-check');
                $('.btn-primary').prop('disabled', true).html('<i class="fas fa-check me-2"></i>Copied!');

                setTimeout(() => {
                    $('.btn-primary').prop('disabled', false).html(
                        '<i class="fas fa-copy me-2"></i>Copy Number');
                }, 2000);

            }).catch(function() {
                showNotification('Failed to copy configuration number.', 'error');
            });
        }

        /**
         * Show notification messages
         */
        function showNotification(message, type = 'info') {
            const alertClass = type === 'success' ? 'alert-success' :
                type === 'error' ? 'alert-danger' :
                type === 'warning' ? 'alert-warning' : 'alert-info';

            const icon = type === 'success' ? 'check-circle' :
                type === 'error' ? 'exclamation-triangle' :
                type === 'warning' ? 'exclamation-triangle' : 'info-circle';

            const notification = $(`
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            <i class="fas fa-${icon} me-2"></i>${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `);

            // Prepend to compatibility alerts container
            $('#compatibility-alerts').prepend(notification);

            // Auto-remove after 5 seconds
            setTimeout(() => {
                notification.alert('close');
            }, 5000);
        }
    </script>
@endpush
