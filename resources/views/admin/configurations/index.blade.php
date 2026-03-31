@extends('layouts.admin')

@section('title', 'Saved Configurations - MK Gilze Africa')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Saved Configurations</h1>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow">
    <div class="card-body">
        @if($configurations->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Config Number</th>
                        <th>Machine</th>
                        <th>Customer</th>
                        <th>Components</th>
                        <th>Total Price</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($configurations as $config)
                    <tr>
                        <td><code>{{ $config->configuration_number }}</code></td>
                        <td>{{ $config->machine->display_name }}</td>
                        <td>
                            <strong>{{ $config->customer_name }}</strong><br>
                            <small class="text-muted">{{ $config->customer_email }}</small>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $config->components_count }}</span>
                        </td>
                        <td>€{{ number_format($config->total_price, 2) }}</td>
                        <td>{{ $config->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.configurations.show', $config) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('configurator.load', $config->configuration_number) }}" 
                                   class="btn btn-outline-success" target="_blank">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-4">
            <i class="fas fa-cogs fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No saved configurations</h5>
            <p class="text-muted">Configurations will appear here once users save them.</p>
        </div>
        @endif
    </div>
</div>
@endsection