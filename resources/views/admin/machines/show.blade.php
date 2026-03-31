@extends('layouts.admin')

@section('title', $machine->display_name . ' - MK Gilze Africa')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">{{ $machine->display_name }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.machines.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Machines
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Machine Details</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="30%">Code:</th>
                        <td>{{ $machine->name }}</td>
                    </tr>
                    <tr>
                        <th>Display Name:</th>
                        <td>{{ $machine->display_name }}</td>
                    </tr>
                    <tr>
                        <th>Base Price:</th>
                        <td class="h5 text-primary">€{{ number_format($machine->base_price, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            @if($machine->active)
                            <span class="badge bg-success">Active</span>
                            @else
                            <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Description:</th>
                        <td>{{ $machine->description }}</td>
                    </tr>
                </table>

                @if($machine->specifications)
                <h6 class="mt-4">Specifications:</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        @foreach($machine->specifications as $key => $value)
                        <tr>
                            <th width="40%">{{ $key }}</th>
                            <td>{{ $value }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Compatible Components</h5>
            </div>
            <div class="card-body">
                @if($machine->components->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($machine->components->groupBy('category.name') as $categoryName => $components)
                    <div class="list-group-item px-0">
                        <h6 class="mb-2">{{ $categoryName }}</h6>
                        @foreach($components as $component)
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span>{{ $component->name }}</span>
                            <small class="text-muted">€{{ number_format($component->price, 2) }}</small>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-muted mb-0">No components configured for this machine.</p>
                @endif
            </div>
        </div>
        
        <div class="card shadow mt-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.machines.edit', $machine) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit Machine
                    </a>
                    <form action="{{ route('admin.machines.destroy', $machine) }}" method="POST" class="d-grid">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                            <i class="fas fa-trash me-2"></i>Delete Machine
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection