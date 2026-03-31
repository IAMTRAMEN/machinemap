{{-- resources/views/admin/simple-relationships/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Contact Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Contact Details</h1>
        <div>
            <a href="{{ route('admin.relationships.edit', $simpleRelationship) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit Contact
            </a>
            <a href="{{ route('admin.relationships.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Contacts
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Contact Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Name</h6>
                            <p class="fs-5">{{ $simpleRelationship->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Company</h6>
                            <p class="fs-5">{{ $simpleRelationship->company ?? 'Not specified' }}</p>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h6>Position</h6>
                            <p>{{ $simpleRelationship->position ?? 'Not specified' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Relationship Type</h6>
                            <p>
                                <span class="badge {{ $simpleRelationship->type_badge }}">
                                    {{ ucfirst($simpleRelationship->relationship_type) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h6>Phone</h6>
                            <p>
                                <i class="fas fa-phone text-muted me-2"></i>
                                {{ $simpleRelationship->phone ?? 'Not specified' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6>Email</h6>
                            <p>
                                <i class="fas fa-envelope text-muted me-2"></i>
                                @if($simpleRelationship->email)
                                    <a href="mailto:{{ $simpleRelationship->email }}">{{ $simpleRelationship->email }}</a>
                                @else
                                    Not specified
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h6>Status</h6>
                            <p>
                                <span class="badge bg-{{ $simpleRelationship->status === 'active' ? 'success' : ($simpleRelationship->status === 'pending' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($simpleRelationship->status) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6>Created</h6>
                            <p>{{ $simpleRelationship->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    @if($simpleRelationship->description)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6>Description / Notes</h6>
                            <div class="border rounded p-3 bg-light">
                                {{ $simpleRelationship->description }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="tel:{{ $simpleRelationship->phone }}" class="btn btn-success" {{ !$simpleRelationship->phone ? 'disabled' : '' }}>
                            <i class="fas fa-phone"></i> Call Contact
                        </a>
                        <a href="mailto:{{ $simpleRelationship->email }}" class="btn btn-primary" {{ !$simpleRelationship->email ? 'disabled' : '' }}>
                            <i class="fas fa-envelope"></i> Send Email
                        </a>
                        <a href="{{ route('admin.relationships.edit', $simpleRelationship) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Contact
                        </a>
                        <form action="{{ route('admin.relationships.destroy', $simpleRelationship) }}" method="POST" class="d-grid">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this contact?')">
                                <i class="fas fa-trash"></i> Delete Contact
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title">Contact Summary</h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="mb-3">
                            <i class="fas fa-user-circle fa-3x text-primary"></i>
                        </div>
                        <h5>{{ $simpleRelationship->name }}</h5>
                        <p class="text-muted">{{ $simpleRelationship->company ?? 'No company' }}</p>
                        <div class="mt-3">
                            <span class="badge {{ $simpleRelationship->type_badge }} me-2">
                                {{ ucfirst($simpleRelationship->relationship_type) }}
                            </span>
                            <span class="badge bg-{{ $simpleRelationship->status === 'active' ? 'success' : ($simpleRelationship->status === 'pending' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($simpleRelationship->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection