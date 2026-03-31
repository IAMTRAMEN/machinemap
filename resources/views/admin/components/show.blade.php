@extends('layouts.admin')

@section('title', $component->name . ' - MK Gilze Africa')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">{{ $component->name }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.components.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Components
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Component Details</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="30%">Name:</th>
                        <td>{{ $component->name }}</td>
                    </tr>
                    <tr>
                        <th>Code:</th>
                        <td><code class="fs-5">{{ $component->code }}</code></td>
                    </tr>
                    <tr>
                        <th>Category:</th>
                        <td>
                            <span class="badge bg-info">{{ $component->category->name }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>Price:</th>
                        <td class="h5 text-primary">€{{ number_format($component->price, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Installation Time:</th>
                        <td>
                            <span class="badge bg-secondary">{{ $component->installation_time }} hours</span>
                        </td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            @if($component->active)
                            <span class="badge bg-success">Active</span>
                            @else
                            <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Description:</th>
                        <td>
                            @if($component->description)
                            {{ $component->description }}
                            @else
                            <span class="text-muted">No description provided</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Compatibility Rules -->
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">Compatibility Rules</h5>
            </div>
            <div class="card-body">
                @php
                    $triggerRules = $component->triggerRules;
                    $targetRules = $component->targetRules;
                @endphp

                @if($triggerRules->count() > 0)
                <h6>Rules where this component triggers:</h6>
                <div class="list-group mb-3">
                    @foreach($triggerRules as $rule)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <strong>{{ $rule->name }}</strong>
                                <br>
                                <small class="text-muted">
                                    <span class="fw-bold">{{ $component->name }}</span>
                                    <span class="badge bg-info mx-2">{{ $rule->operator }}</span>
                                    <span class="fw-bold">{{ $rule->targetComponent->name }}</span>
                                </small>
                                @if($rule->description)
                                <br>
                                <small class="text-muted">{{ $rule->description }}</small>
                                @endif
                            </div>
                            <div class="text-end">
                                @if($rule->active)
                                <span class="badge bg-success">Active</span>
                                @else
                                <span class="badge bg-secondary">Inactive</span>
                                @endif
                                <br>
                                <small class="text-muted">
                                    @if($rule->block_configuration)
                                    <span class="badge bg-danger">Blocks</span>
                                    @endif
                                    @if($rule->auto_select)
                                    <span class="badge bg-warning">Auto-select</span>
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                @if($targetRules->count() > 0)
                <h6>Rules where this component is targeted:</h6>
                <div class="list-group">
                    @foreach($targetRules as $rule)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <strong>{{ $rule->name }}</strong>
                                <br>
                                <small class="text-muted">
                                    <span class="fw-bold">{{ $rule->triggerComponent->name }}</span>
                                    <span class="badge bg-info mx-2">{{ $rule->operator }}</span>
                                    <span class="fw-bold">{{ $component->name }}</span>
                                </small>
                                @if($rule->description)
                                <br>
                                <small class="text-muted">{{ $rule->description }}</small>
                                @endif
                            </div>
                            <div class="text-end">
                                @if($rule->active)
                                <span class="badge bg-success">Active</span>
                                @else
                                <span class="badge bg-secondary">Inactive</span>
                                @endif
                                <br>
                                <small class="text-muted">
                                    @if($rule->block_configuration)
                                    <span class="badge bg-danger">Blocks</span>
                                    @endif
                                    @if($rule->auto_select)
                                    <span class="badge bg-warning">Auto-select</span>
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                @if($triggerRules->count() == 0 && $targetRules->count() == 0)
                <p class="text-muted mb-0">No compatibility rules defined for this component.</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Compatible Machines -->
        <div class="card shadow mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Compatible Machines</h5>
            </div>
            <div class="card-body">
                @if($component->machines->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($component->machines as $machine)
                    <div class="list-group-item px-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $machine->display_name }}</strong>
                                <br>
                                <small class="text-muted">{{ $machine->name }}</small>
                            </div>
                            <span class="badge bg-primary">€{{ number_format($machine->base_price, 2) }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-muted mb-0">This component is not compatible with any machines.</p>
                @endif
            </div>
        </div>
        
        <!-- Usage Statistics -->
        <div class="card shadow mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Usage Statistics</h5>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="mb-3">
                        <i class="fas fa-cogs fa-2x text-info mb-2"></i>
                        <h4>{{ $component->machines->count() }}</h4>
                        <small class="text-muted">Compatible Machines</small>
                    </div>
                    <div class="mb-3">
                        <i class="fas fa-random fa-2x text-warning mb-2"></i>
                        <h4>{{ $component->triggerRules->count() + $component->targetRules->count() }}</h4>
                        <small class="text-muted">Total Rules</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="card shadow">
            <div class="card-header bg-light">
                <h5 class="mb-0">Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.components.edit', $component) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit Component
                    </a>
                    <form action="{{ route('admin.components.destroy', $component) }}" method="POST" class="d-grid">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure? This will remove the component from all machines and rules.')">
                            <i class="fas fa-trash me-2"></i>Delete Component
                        </button>
                    </form>
                    <a href="{{ route('admin.rules.create') }}?trigger_component_id={{ $component->id }}" class="btn btn-info">
                        <i class="fas fa-plus me-2"></i>Add Rule with This
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection