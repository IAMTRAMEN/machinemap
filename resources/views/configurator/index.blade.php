@extends('layouts.app')

@section('title', 'Machine Configurator - MK Gilze Africa')

@section('content')
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h1 class="display-4">Machine Configurator</h1>
            <p class="lead">Design your perfect packaging solution with our interactive configurator</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card bg-light">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4 mb-3">
                            <i class="fas fa-cogs fa-2x text-primary mb-2"></i>
                            <h5>Configure</h5>
                            <p class="small text-muted">Build your custom machine from scratch</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <i class="fas fa-exchange-alt fa-2x text-success mb-2"></i>
                            <h5>Compare</h5>
                            <p class="small text-muted">Compare different configurations side by side</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <i class="fas fa-save fa-2x text-info mb-2"></i>
                            <h5>Save & Share</h5>
                            <p class="small text-muted">Save your configurations for later use</p>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('configurator.compare') }}" class="btn btn-outline-primary me-2">
                            <i class="fas fa-exchange-alt me-2"></i>Compare Machines
                        </a>
                        <button class="btn btn-outline-info" data-bs-toggle="modal"
                            data-bs-target="#loadConfigurationModal">
                            <i class="fas fa-folder-open me-2"></i>Load Saved Configuration
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Bar - MOVED OUTSIDE FEATURED SECTION -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form id="search-form" method="GET" action="{{ route('configurator.index') }}">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-8">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" name="search" id="search-input" class="form-control"
                                        placeholder="Search machines by name, model, or description..."
                                        value="{{ $search ?? '' }}" autocomplete="off">
                                    @if ($search ?? false)
                                        <button type="button" class="btn btn-outline-secondary" onclick="clearSearch()">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-search me-2"></i>Search
                                </button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('configurator.index') }}" class="btn btn-outline-secondary btn-lg w-100">
                                    <i class="fas fa-refresh me-2"></i>Reset
                                </a>
                            </div>
                        </div>

                        {{-- Quick search suggestions --}}
                        <div class="mt-2">
                            <small class="text-muted">
                                <strong>Quick search:</strong>
                                <span class="ms-2">
                                    @php
                                        $suggestions = ['Filling', 'Packaging', 'Labeling', 'Sealing', 'Wrapping'];
                                    @endphp
                                    @foreach ($suggestions as $suggestion)
                                        <a href="#" class="quick-search text-decoration-none ms-2"
                                            data-search="{{ $suggestion }}">
                                            {{ $suggestion }}
                                        </a>
                                        @if (!$loop->last)
                                            |
                                        @endif
                                    @endforeach
                                </span>
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Results Info -->
    @if ($search ?? false)
        <div class="row mb-4">
            <div class="col-12">
                <div
                    class="alert {{ $featuredMachines->count() + $allMachines->count() > 0 ? 'alert-info' : 'alert-warning' }} d-flex align-items-center">
                    <i
                        class="fas {{ $featuredMachines->count() + $allMachines->count() > 0 ? 'fa-info-circle' : 'fa-search' }} me-2"></i>
                    <div class="flex-grow-1">
                        <strong>Search Results for "{{ $search }}"</strong>
                        <span class="ms-2">
                            @if ($featuredMachines->count() + $allMachines->count() > 0)
                                Found {{ $featuredMachines->count() + $allMachines->count() }} machine(s)
                            @else
                                No machines found matching your search
                            @endif
                        </span>
                    </div>
                    <button type="button" class="btn-close" onclick="clearSearch()" aria-label="Close"></button>
                </div>
            </div>
        </div>

        <!-- No Results Message -->
        @if ($featuredMachines->count() + $allMachines->count() === 0)
            <div class="row mb-5">
                <div class="col-12">
                    <div class="card border-warning">
                        <div class="card-body text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-search fa-4x text-warning mb-3"></i>
                                <h3 class="text-warning">No Machines Found</h3>
                            </div>

                            <p class="lead mb-4">We couldn't find any machines matching
                                "<strong>{{ $search }}</strong>"</p>

                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h5 class="mb-3">Suggestions:</h5>
                                            <ul class="list-unstyled mb-0">
                                                <li class="mb-2">
                                                    <i class="fas fa-check text-success me-2"></i>
                                                    Check your spelling and try again
                                                </li>
                                                <li class="mb-2">
                                                    <i class="fas fa-check text-success me-2"></i>
                                                    Try more general keywords
                                                </li>
                                                <li class="mb-2">
                                                    <i class="fas fa-check text-success me-2"></i>
                                                    Browse all machines below
                                                </li>
                                                <li>
                                                    <i class="fas fa-check text-success me-2"></i>
                                                    Contact us for custom solutions
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button class="btn btn-primary me-2" onclick="clearSearch()">
                                    <i class="fas fa-times me-2"></i>Clear Search
                                </button>
                                <a href="/" class="btn btn-outline-primary">
                                    <i class="fas fa-list me-2"></i>Browse All Machines
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif

    <!-- Featured Machines -->
    @if ($featuredMachines->count() > 0)
        <div class="row mb-5">
            <div class="col-12">
                @if ($search)
                    <h2 class="text-center mb-4"><i class="fas fa-star text-warning me-2"></i>Top Matching Machines</h2>
                @else
                    <h2 class="text-center mb-4">Featured Machines</h2>
                @endif
                <div class="row justify-content-center">
                    @foreach ($featuredMachines as $machine)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm featured-machine {{ $search ? 'search-match' : '' }}">
                                @if ($machine->image_url)
                                    <img src="{{ $machine->image_url }}" class="card-img-top"
                                        alt="{{ $machine->display_name }}" style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                        style="height: 200px;">
                                        <i class="fas fa-cogs fa-4x text-muted"></i>
                                    </div>
                                @endif

                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title">{{ $machine->display_name }}</h5>
                                        @if ($search)
                                            <span class="badge bg-warning text-dark">Search Match</span>
                                        @else
                                            <span class="badge bg-warning">Featured</span>
                                        @endif
                                    </div>
                                    <h6 class="card-subtitle mb-2 text-muted">Model: {{ $machine->name }}</h6>
                                    <p class="card-text flex-grow-1">{{ Str::limit($machine->description, 100) }}</p>

                                    @if ($machine->specifications)
                                        <div class="machine-specs mb-3">
                                            <strong>Key Features:</strong>
                                            <ul class="list-unstyled mb-0">
                                                @foreach (array_slice($machine->specifications, 0, 2) as $key => $value)
                                                    <li><small>{{ $key }}: {{ $value }}</small></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span
                                                class="h4 text-primary mb-0">€{{ number_format($machine->base_price, 2) }}</span>
                                            @if (!$search)
                                                <span class="badge bg-success">Best Value</span>
                                            @endif
                                        </div>

                                        <a href="{{ route('configurator.show', $machine->id) }}"
                                            class="btn btn-primary w-100">
                                            <i class="fas fa-cog me-2"></i>Configure Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- All Machines -->
    @if ($allMachines->count() > 0)
        <div class="row" id="all-machines">
            <div class="col-12">
                @if ($search)
                    <h2 class="text-center mb-4"><i class="fas fa-list me-2"></i>Other Matching Machines</h2>
                @else
                    <h2 class="text-center mb-4">All Available Machines</h2>
                @endif
                <div class="row">
                    @foreach ($allMachines as $machine)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm {{ $search ? 'search-match' : '' }}">
                                @if ($machine->image_url)
                                    <img src="{{ $machine->image_url }}" class="card-img-top"
                                        alt="{{ $machine->display_name }}" style="height: 180px; object-fit: cover;">
                                @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                        style="height: 180px;">
                                        <i class="fas fa-cogs fa-3x text-muted"></i>
                                    </div>
                                @endif

                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $machine->display_name }}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Model: {{ $machine->name }}</h6>
                                    <p class="card-text flex-grow-1">{{ Str::limit($machine->description, 80) }}</p>

                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span
                                                class="h5 text-primary mb-0">€{{ number_format($machine->base_price, 2) }}</span>
                                        </div>

                                        <a href="{{ route('configurator.show', $machine->id) }}"
                                            class="btn btn-outline-primary w-100">
                                            <i class="fas fa-cog me-2"></i>Configure
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Load Configuration Modal -->
    <div class="modal fade" id="loadConfigurationModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Load Saved Configuration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="load-configuration-form">
                        <div class="mb-3">
                            <label for="configuration_number" class="form-label">Configuration Number</label>
                            <input type="text" class="form-control" id="configuration_number"
                                placeholder="Enter your configuration number (e.g., CFG20240120001)" required>
                            <div class="form-text">Enter the configuration number you received when saving your
                                configuration.</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="loadConfiguration()">
                        <i class="fas fa-folder-open me-2"></i>Load Configuration
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- How It Works -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card bg-light">
                <div class="card-body">
                    <h3 class="text-center mb-4">How It Works</h3>
                    <br>
                    <div class="row">
                        <div class="col-md-3 text-center mb-3">
                            <div class="step-number"></div>
                            <i class="fas fa-mouse-pointer fa-2x text-primary mb-2"></i>
                            <h5>Select Machine</h5>
                            <p class="small">Choose from our range of packaging machines</p>
                        </div>
                        <div class="col-md-3 text-center mb-3">
                            <div class="step-number"></div>
                            <i class="fas fa-sliders-h fa-2x text-primary mb-2"></i>
                            <h5>Customize</h5>
                            <p class="small">Add components and features that match your needs</p>
                        </div>
                        <div class="col-md-3 text-center mb-3">
                            <div class="step-number"></div>
                            <i class="fas fa-calculator fa-2x text-primary mb-2"></i>
                            <h5>Get Instant Quote</h5>
                            <p class="small">See real-time pricing as you configure</p>
                        </div>
                        <div class="col-md-3 text-center mb-3">
                            <div class="step-number"></div>
                            <i class="fas fa-download fa-2x text-primary mb-2"></i>
                            <h5>Save & Download</h5>
                            <p class="small">Save your configuration and download PDF quote</p>
                        </div>
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

        .quick-search:hover {
            color: var(--primary) !important;
            text-decoration: underline !important;
        }

        mark {
            padding: 0.1em 0.2em;
            border-radius: 0.25em;
            font-weight: 600;
        }

        .search-highlight {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
        }

        .card.search-match {
            border: 2px solid #ffc107;
            box-shadow: 0 4px 12px rgba(255, 193, 7, 0.2);
        }
    </style>
@endpush

@push('scripts')
    <script>
        function loadConfiguration() {
            const configNumber = document.getElementById('configuration_number').value.trim();
            if (!configNumber) {
                alert('Please enter a configuration number');
                return;
            }

            // Show loading state
            const loadBtn = document.querySelector('#loadConfigurationModal .btn-primary');
            loadBtn.disabled = true;
            loadBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';

            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('loadConfigurationModal'));
            modal.hide();

            // Redirect to load configuration
            window.location.href = '/configurator/load/' + configNumber;
        }

        // Close modal on successful load
        document.getElementById('configuration_number').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                loadConfiguration();
            }
        });

        $(document).ready(function() {
            // Quick search links
            $('.quick-search').click(function(e) {
                e.preventDefault();
                const searchTerm = $(this).data('search');
                $('#search-input').val(searchTerm);
                $('#search-form').submit();
            });

            // Auto-submit on Enter (optional)
            $('#search-input').keypress(function(e) {
                if (e.which === 13) { // Enter key
                    $('#search-form').submit();
                }
            });

            // Highlight search terms in results
            @if ($search ?? false)
                highlightSearchTerms('{{ $search }}');
            @endif
        });

        function clearSearch() {
            window.location.href = '{{ route('configurator.index') }}';
        }

        function highlightSearchTerms(searchTerm) {
            const terms = searchTerm.toLowerCase().split(' ');
            const elements = document.querySelectorAll('.card-title, .card-text, .card-subtitle');

            elements.forEach(element => {
                let html = element.innerHTML;
                terms.forEach(term => {
                    if (term.length > 2) { // Only highlight terms longer than 2 characters
                        const regex = new RegExp(`(${term})`, 'gi');
                        html = html.replace(regex, '<mark class="bg-warning">$1</mark>');
                    }
                });
                element.innerHTML = html;
            });
        }

        // Optional: Real-time search with debouncing
        let searchTimeout;
        $('#search-input').on('input', function() {
            clearTimeout(searchTimeout);
            const searchValue = $(this).val();

            if (searchValue.length > 2 || searchValue.length === 0) {
                searchTimeout = setTimeout(() => {
                    $('#search-form').submit();
                }, 500); // Wait 500ms after user stops typing
            }
        });
    </script>
@endpush
