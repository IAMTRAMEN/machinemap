@extends('layouts.admin')

@section('title', 'Manage Components - MK Gilze Africa')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manage Components</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.components.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Component
        </a>
    </div>
</div>

<div class="card shadow">
    <div class="card-body">
        @if($components->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Installation Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($components as $component)
                    <tr>
                        <td><code>{{ $component->code }}</code></td>
                        <td>
                            <strong>{{ $component->name }}</strong>
                            @if($component->description)
                            <br><small class="text-muted">{{ Str::limit($component->description, 50) }}</small>
                            @endif
                        </td>
                        <td>{{ $component->category->name }}</td>
                        <td>€{{ number_format($component->price, 2) }}</td>
                        <td>{{ $component->installation_time }} hours</td>
                        <td>
                            @if($component->active)
                            <span class="badge bg-success">Active</span>
                            @else
                            <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.components.show', $component) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.components.edit', $component) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.components.destroy', $component) }}" method="POST" class="d-inline">
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
            <i class="fas fa-puzzle-piece fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No components found</h5>
            <p class="text-muted">Get started by adding your first component.</p>
            <a href="{{ route('admin.components.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add Component
            </a>
        </div>
        @endif
    </div>
</div>
@endsection