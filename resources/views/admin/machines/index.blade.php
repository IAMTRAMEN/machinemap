@extends('layouts.admin')

@section('title', 'Manage Machines - MK Gilze Africa')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manage Machines</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.machines.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Machine
        </a>
    </div>
</div>

<div class="card shadow">
    <div class="card-body">
        @if($machines->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Display Name</th>
                        <th>Base Price</th>
                        <th>Components</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($machines as $machine)
                    <tr>
                        <td>
                            <strong>{{ $machine->name }}</strong>
                            @if($machine->image_url)
                            <br><small class="text-muted">Has image</small>
                            @endif
                        </td>
                        <td>{{ $machine->display_name }}</td>
                        <td>€{{ number_format($machine->base_price, 2) }}</td>
                        <td>
                            <span class="badge bg-info">{{ $machine->components_count }} components</span>
                        </td>
                        <td>
                            @if($machine->active)
                            <span class="badge bg-success">Active</span>
                            @else
                            <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.machines.show', $machine) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.machines.edit', $machine) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.machines.destroy', $machine) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
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
            <h5 class="text-muted">No machines found</h5>
            <p class="text-muted">Get started by adding your first machine.</p>
            <a href="{{ route('admin.machines.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add Machine
            </a>
        </div>
        @endif
    </div>
</div>
@endsection