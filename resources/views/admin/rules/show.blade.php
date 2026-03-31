@extends('layouts.admin')

@section('title', $rule->name . ' - MK Gilze Africa')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">{{ $rule->name }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.rules.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Rules
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Rule Details</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="30%">Rule Name:</th>
                        <td>{{ $rule->name }}</td>
                    </tr>
                    <tr>
                        <th>Description:</th>
                        <td>
                            @if($rule->description)
                            {{ $rule->description }}
                            @else
                            <span class="text-muted">No description provided</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            @if($rule->active)
                            <span class="badge bg-success">Active</span>
                            @else
                            <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Created:</th>
                        <td>{{ $rule->created_at->format('M d, Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Last Updated:</th>
                        <td>{{ $rule->updated_at->format('M d, Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Rule Logic -->
        <div class="card shadow mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Rule Logic</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6>Trigger Component</h6>
                                <div class="mb-3">
                                    <i class="fas fa-mouse-pointer fa-2x text-primary mb-2"></i>
                                    <h5>{{ $rule->triggerComponent->name }}</h5>
                                    <small class="text-muted">Code: {{ $rule->triggerComponent->code }}</small>
                                    <br>
                                    <small class="text-muted">€{{ number_format($rule->triggerComponent->price, 2) }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6>Operator</h6>
                                <div class="mb-3">
                                    <i class="fas fa-arrow-right fa-2x text-warning mb-2"></i>
                                    <h5>
                                        @if($rule->operator === 'requires')
                                        <span class="badge bg-success">REQUIRES</span>
                                        @elseif($rule->operator === 'incompatible_with')
                                        <span class="badge bg-danger">INCOMPATIBLE WITH</span>
                                        @else
                                        <span class="badge bg-info">RECOMMENDS</span>
                                        @endif
                                    </h5>
                                    <small class="text-muted">Relationship Type</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6>Target Component</h6>
                                <div class="mb-3">
                                    <i class="fas fa-bullseye fa-2x text-success mb-2"></i>
                                    <h5>{{ $rule->targetComponent->name }}</h5>
                                    <small class="text-muted">Code: {{ $rule->targetComponent->code }}</small>
                                    <br>
                                    <small class="text-muted">€{{ number_format($rule->targetComponent->price, 2) }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 p-3 bg-light rounded">
                    <h6 class="text-center">Rule Summary:</h6>
                    <p class="text-center mb-0 lead">
                        <strong>"{{ $rule->triggerComponent->name }}"</strong>
                        <span class="mx-3">
                            @if($rule->operator === 'requires')
                            <strong class="text-success">REQUIRES</strong>
                            @elseif($rule->operator === 'incompatible_with')
                            <strong class="text-danger">CANNOT BE COMBINED WITH</strong>
                            @else
                            <strong class="text-info">RECOMMENDS</strong>
                            @endif
                        </span>
                        <strong>"{{ $rule->targetComponent->name }}"</strong>
                    </p>
                </div>
            </div>
        </div>

        <!-- Rule Messages -->
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">Rule Messages</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Error Message:</h6>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ $rule->error_message }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6>Success Message:</h6>
                        @if($rule->success_message)
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ $rule->success_message }}
                        </div>
                        @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            No success message configured
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Rule Actions -->
        <div class="card shadow mb-4">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">Rule Actions</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Configuration Behavior:</strong>
                    <br>
                    @if($rule->block_configuration)
                    <span class="badge bg-danger">
                        <i class="fas fa-ban me-1"></i>Blocks Configuration
                    </span>
                    <small class="d-block text-muted mt-1">
                        Prevents quote generation when rule is violated
                    </small>
                    @else
                    <span class="badge bg-warning">
                        <i class="fas fa-exclamation-triangle me-1"></i>Warning Only
                    </span>
                    <small class="d-block text-muted mt-1">
                        Shows warning but allows configuration
                    </small>
                    @endif
                </div>

                <div class="mb-3">
                    <strong>Auto-selection:</strong>
                    <br>
                    @if($rule->auto_select && $rule->operator === 'requires')
                    <span class="badge bg-success">
                        <i class="fas fa-magic me-1"></i>Auto-Selects Required
                    </span>
                    <small class="d-block text-muted mt-1">
                        Automatically adds required component
                    </small>
                    @else
                    <span class="badge bg-secondary">
                        <i class="fas fa-hand-pointer me-1"></i>Manual Selection
                    </span>
                    <small class="d-block text-muted mt-1">
                        User must manually select components
                    </small>
                    @endif
                </div>

                <div class="mt-3 p-3 bg-light rounded">
                    <small class="text-muted">
                        <strong>Rule Type:</strong> 
                        @if($rule->operator === 'requires')
                        <span class="text-success">Dependency Rule</span>
                        @elseif($rule->operator === 'incompatible_with')
                        <span class="text-danger">Conflict Rule</span>
                        @else
                        <span class="text-info">Recommendation Rule</span>
                        @endif
                    </small>
                </div>
            </div>
        </div>

        <!-- Component Details -->
        <div class="card shadow mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">Component Details</h5>
            </div>
            <div class="card-body">
                <h6>Trigger Component:</h6>
                <div class="d-flex justify-content-between align-items-center mb-3 p-2 bg-light rounded">
                    <div>
                        <strong>{{ $rule->triggerComponent->name }}</strong>
                        <br>
                        <small class="text-muted">{{ $rule->triggerComponent->category->name }}</small>
                    </div>
                    <span class="badge bg-primary">€{{ number_format($rule->triggerComponent->price, 2) }}</span>
                </div>

                <h6>Target Component:</h6>
                <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                    <div>
                        <strong>{{ $rule->targetComponent->name }}</strong>
                        <br>
                        <small class="text-muted">{{ $rule->targetComponent->category->name }}</small>
                    </div>
                    <span class="badge bg-primary">€{{ number_format($rule->targetComponent->price, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Management Actions -->
        <div class="card shadow">
            <div class="card-header bg-light">
                <h5 class="mb-0">Management</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.rules.edit', $rule) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit Rule
                    </a>
                    <form action="{{ route('admin.rules.destroy', $rule) }}" method="POST" class="d-grid">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this rule?')">
                            <i class="fas fa-trash me-2"></i>Delete Rule
                        </button>
                    </form>
                    <a href="{{ route('admin.components.show', $rule->triggerComponent) }}" class="btn btn-outline-primary">
                        <i class="fas fa-eye me-2"></i>View Trigger Component
                    </a>
                    <a href="{{ route('admin.components.show', $rule->targetComponent) }}" class="btn btn-outline-success">
                        <i class="fas fa-eye me-2"></i>View Target Component
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection