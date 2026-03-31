{{-- resources/views/admin/simple-relationships/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Contact Management')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Contact Management</h1>
        <a href="{{ route('admin.relationships.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Contact
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($relationships->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Company</th>
                            <th>Contact</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($relationships as $relationship)
                        <tr>
                            <td>
                                <strong>{{ $relationship->name }}</strong>
                                @if($relationship->position)
                                    <br><small class="text-muted">{{ $relationship->position }}</small>
                                @endif
                            </td>
                            <td>{{ $relationship->company ?? '-' }}</td>
                            <td>
                                @if($relationship->phone)
                                    <div><i class="fas fa-phone text-muted me-2"></i>{{ $relationship->phone }}</div>
                                @endif
                                @if($relationship->email)
                                    <div><i class="fas fa-envelope text-muted me-2"></i>{{ $relationship->email }}</div>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $relationship->type_badge }}">
                                    {{ ucfirst($relationship->relationship_type) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $relationship->status === 'active' ? 'success' : ($relationship->status === 'pending' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($relationship->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.relationships.show', $relationship) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.relationships.edit', $relationship) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $relationships->links() }}
            @else
            <div class="text-center py-4">
                <i class="fas fa-address-book fa-3x text-muted mb-3"></i>
                <p class="text-muted">No contacts found.</p>
                <a href="{{ route('admin.relationships.create') }}" class="btn btn-primary">
                    Add First Contact
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection