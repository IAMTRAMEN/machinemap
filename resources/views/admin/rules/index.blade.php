@extends('layouts.admin')

@section('title', 'Manage Compatibility Rules - MK Gilze Africa')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manage Compatibility Rules</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.rules.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Rule
        </a>
    </div>
</div>

<div class="card shadow">
    <div class="card-body">
        @if($rules->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Rule Name</th>
                        <th>Logic</th>
                        <th>Actions</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rules as $rule)
                    <tr>
                        <td>
                            <strong>{{ $rule->name }}</strong>
                            @if($rule->description)
                            <br><small class="text-muted">{{ $rule->description }}</small>
                            @endif
                        </td>
                        <td>
                            <span class="fw-bold">{{ $rule->triggerComponent->name }}</span>
                            <span class="badge bg-info mx-2">{{ $rule->operator }}</span>
                            <span class="fw-bold">{{ $rule->targetComponent->name }}</span>
                        </td>
                        <td>
                            @if($rule->block_configuration)
                            <span class="badge bg-danger">Blocks Configuration</span>
                            @endif
                            @if($rule->auto_select)
                            <span class="badge bg-warning">Auto-Select</span>
                            @endif
                        </td>
                        <td>
                            @if($rule->active)
                            <span class="badge bg-success">Active</span>
                            @else
                            <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                 <a href="{{ route('admin.rules.show', $rule) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.rules.edit', $rule) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.rules.destroy', $rule) }}" method="POST" class="d-inline">
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
            <i class="fas fa-random fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No compatibility rules found</h5>
            <p class="text-muted">Get started by adding your first compatibility rule.</p>
            <a href="{{ route('admin.rules.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add Rule
            </a>
        </div>
        @endif
    </div>
</div>
@endsection