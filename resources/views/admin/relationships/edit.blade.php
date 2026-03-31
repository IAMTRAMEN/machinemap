{{-- resources/views/admin/simple-relationships/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Contact')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Edit Contact</h1>
        <a href="{{ route('admin.relationships.show', $simpleRelationship) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Contact
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.relationships.update', $simpleRelationship) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Contact Name *</label>
                            <input type="text" name="name" id="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $simpleRelationship->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="company" class="form-label">Company</label>
                            <input type="text" name="company" id="company" 
                                   class="form-control @error('company') is-invalid @enderror" 
                                   value="{{ old('company', $simpleRelationship->company) }}">
                            @error('company')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" name="phone" id="phone" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   value="{{ old('phone', $simpleRelationship->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $simpleRelationship->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="relationship_type" class="form-label">Relationship Type *</label>
                            <select name="relationship_type" id="relationship_type" 
                                    class="form-select @error('relationship_type') is-invalid @enderror" required>
                                <option value="">Select Type</option>
                                <option value="customer" {{ old('relationship_type', $simpleRelationship->relationship_type) == 'customer' ? 'selected' : '' }}>Customer</option>
                                <option value="provider" {{ old('relationship_type', $simpleRelationship->relationship_type) == 'provider' ? 'selected' : '' }}>Provider</option>
                                <option value="partner" {{ old('relationship_type', $simpleRelationship->relationship_type) == 'partner' ? 'selected' : '' }}>Partner</option>
                                <option value="other" {{ old('relationship_type', $simpleRelationship->relationship_type) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('relationship_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status *</label>
                            <select name="status" id="status" 
                                    class="form-select @error('status') is-invalid @enderror" required>
                                <option value="active" {{ old('status', $simpleRelationship->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $simpleRelationship->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="pending" {{ old('status', $simpleRelationship->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description / Notes</label>
                    <textarea name="description" id="description" 
                              class="form-control @error('description') is-invalid @enderror" 
                              rows="4" placeholder="Enter any notes or description...">{{ old('description', $simpleRelationship->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('admin.relationships.show', $simpleRelationship) }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Contact</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection