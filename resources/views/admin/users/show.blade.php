@extends('layouts.admin')

@section('title', $user->name . ' - MK Gilze Africa')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">User Details: {{ $user->name }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Users
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">User Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="30%">Name:</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Role:</th>
                        <td>
                            <span class="badge bg-{{ $user->role === 'admin' ? 'primary' : 'secondary' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Account Created:</th>
                        <td>{{ $user->created_at->format('M d, Y g:i A') }}</td>
                    </tr>
                    <tr>
                        <th>Last Updated:</th>
                        <td>{{ $user->updated_at->format('M d, Y g:i A') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header bg-light">
                <h5 class="mb-0">Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit User
                    </a>
                    @if($user->id !== auth()->id())
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-grid">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">
                            <i class="fas fa-trash me-2"></i>Delete User
                        </button>
                    </form>
                    @else
                    <button class="btn btn-secondary" disabled>
                        <i class="fas fa-trash me-2"></i>Cannot Delete Your Account
                    </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="card shadow mt-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Quick Stats</h5>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="mb-3">
                        <div class="h4 text-primary mb-1">{{ $user->created_at->diffForHumans() }}</div>
                        <small class="text-muted">Account Age</small>
                    </div>
                    @if($user->id === auth()->id())
                    <div class="alert alert-info mt-2 mb-0">
                        <small><i class="fas fa-info-circle me-1"></i>This is your account</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection