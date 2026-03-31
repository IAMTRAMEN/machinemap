@extends('layouts.admin')

@section('title', 'Edit Compatibility Rule - MK Gilze Africa')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Rule: {{ $rule->name }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.rules.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Rules
        </a>
    </div>
</div>

<div class="card shadow">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.rules.update', $rule) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="name" class="form-label">Rule Name *</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name', $rule->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="2">{{ old('description', $rule->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="trigger_component_id" class="form-label">When this component is selected *</label>
                        <select class="form-select @error('trigger_component_id') is-invalid @enderror" 
                                id="trigger_component_id" name="trigger_component_id" required>
                            <option value="">Select Trigger Component</option>
                            @foreach($components as $component)
                            <option value="{{ $component->id }}" {{ old('trigger_component_id', $rule->trigger_component_id) == $component->id ? 'selected' : '' }}>
                                {{ $component->name }} ({{ $component->code }})
                            </option>
                            @endforeach
                        </select>
                        @error('trigger_component_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="operator" class="form-label">Then *</label>
                        <select class="form-select @error('operator') is-invalid @enderror" 
                                id="operator" name="operator" required>
                            <option value="">Select Operator</option>
                            <option value="requires" {{ old('operator', $rule->operator) == 'requires' ? 'selected' : '' }}>Requires</option>
                            <option value="incompatible_with" {{ old('operator', $rule->operator) == 'incompatible_with' ? 'selected' : '' }}>Is Incompatible With</option>
                            <option value="recommends" {{ old('operator', $rule->operator) == 'recommends' ? 'selected' : '' }}>Recommends</option>
                        </select>
                        @error('operator')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="target_component_id" class="form-label">This component *</label>
                        <select class="form-select @error('target_component_id') is-invalid @enderror" 
                                id="target_component_id" name="target_component_id" required>
                            <option value="">Select Target Component</option>
                            @foreach($components as $component)
                            <option value="{{ $component->id }}" {{ old('target_component_id', $rule->target_component_id) == $component->id ? 'selected' : '' }}>
                                {{ $component->name }} ({{ $component->code }})
                            </option>
                            @endforeach
                        </select>
                        @error('target_component_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="error_message" class="form-label">Error Message *</label>
                <textarea class="form-control @error('error_message') is-invalid @enderror" 
                          id="error_message" name="error_message" rows="2" required>{{ old('error_message', $rule->error_message) }}</textarea>
                @error('error_message')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="success_message" class="form-label">Success Message</label>
                <textarea class="form-control @error('success_message') is-invalid @enderror" 
                          id="success_message" name="success_message" rows="2">{{ old('success_message', $rule->success_message) }}</textarea>
                @error('success_message')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="block_configuration" name="block_configuration" value="1" 
                               {{ old('block_configuration', $rule->block_configuration) ? 'checked' : '' }}>
                        <label class="form-check-label" for="block_configuration">Block configuration if violated</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="auto_select" name="auto_select" value="1" 
                               {{ old('auto_select', $rule->auto_select) ? 'checked' : '' }}>
                        <label class="form-check-label" for="auto_select">Auto-select required component</label>
                    </div>
                </div>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="active" name="active" value="1" 
                       {{ old('active', $rule->active) ? 'checked' : '' }}>
                <label class="form-check-label" for="active">Active (rule is enforced)</label>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.rules.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update Rule
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const triggerSelect = document.getElementById('trigger_component_id');
    const targetSelect = document.getElementById('target_component_id');
    
    function updateOptions() {
        const triggerValue = triggerSelect.value;
        const targetValue = targetSelect.value;
        
        Array.from(targetSelect.options).forEach(option => {
            option.disabled = false;
        });
        
        if (triggerValue) {
            const triggerOption = targetSelect.querySelector(`option[value="${triggerValue}"]`);
            if (triggerOption) {
                triggerOption.disabled = true;
                if (targetValue === triggerValue) {
                    targetSelect.value = '';
                }
            }
        }
        
        Array.from(triggerSelect.options).forEach(option => {
            option.disabled = false;
        });
        
        if (targetValue) {
            const targetOption = triggerSelect.querySelector(`option[value="${targetValue}"]`);
            if (targetOption) {
                targetOption.disabled = true;
                if (triggerValue === targetValue) {
                    triggerSelect.value = '';
                }
            }
        }
    }
    
    triggerSelect.addEventListener('change', updateOptions);
    targetSelect.addEventListener('change', updateOptions);
    
    updateOptions();
});
</script>
@endpush
@endsection