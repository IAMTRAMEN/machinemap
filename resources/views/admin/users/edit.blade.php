@extends('layouts.admin')

@section('title', 'Edit User - MK Gilze Africa')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit User: {{ $user->name }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Users
        </a>
    </div>
</div>

<div class="card shadow">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address *</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" placeholder="Leave blank to keep current password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Minimum 8 characters</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Role *</label>
                <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                    <option value="">Select Role</option>
                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <div class="card bg-light">
                    <div class="card-body">
                        <h6 class="card-title">User Information</h6>
                        <p class="mb-1"><strong>Created:</strong> {{ $user->created_at->format('M d, Y g:i A') }}</p>
                        <p class="mb-1"><strong>Last Updated:</strong> {{ $user->updated_at->format('M d, Y g:i A') }}</p>
                        @if($user->id === auth()->id())
                        <div class="alert alert-warning mt-2 mb-0">
                            <small><i class="fas fa-exclamation-triangle me-1"></i>You are editing your own account.</small>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection