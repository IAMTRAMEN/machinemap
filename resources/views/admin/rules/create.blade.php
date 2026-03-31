@extends('layouts.admin')

@section('title', 'Add Compatibility Rule - MK Gilze Africa')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Add Compatibility Rule</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.rules.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Rules
        </a>
    </div>
</div>

<div class="card shadow">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.rules.store') }}">
            @csrf
            
            <div class="mb-3">
                <label for="name" class="form-label">Rule Name *</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="2">{{ old('description') }}</textarea>
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
                            <option value="{{ $component->id }}" {{ old('trigger_component_id') == $component->id ? 'selected' : '' }}>
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
                            <option value="requires" {{ old('operator') == 'requires' ? 'selected' : '' }}>Requires</option>
                            <option value="incompatible_with" {{ old('operator') == 'incompatible_with' ? 'selected' : '' }}>Is Incompatible With</option>
                            <option value="recommends" {{ old('operator') == 'recommends' ? 'selected' : '' }}>Recommends</option>
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
                            <option value="{{ $component->id }}" {{ old('target_component_id') == $component->id ? 'selected' : '' }}>
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
                          id="error_message" name="error_message" rows="2" required>{{ old('error_message') }}</textarea>
                <div class="form-text">Message shown when rule is violated</div>
                @error('error_message')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="success_message" class="form-label">Success Message</label>
                <textarea class="form-control @error('success_message') is-invalid @enderror" 
                          id="success_message" name="success_message" rows="2">{{ old('success_message') }}</textarea>
                <div class="form-text">Optional message shown when rule is satisfied</div>
                @error('success_message')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="block_configuration" name="block_configuration" value="1" 
                               {{ old('block_configuration', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="block_configuration">Block configuration if violated</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="auto_select" name="auto_select" value="1" 
                               {{ old('auto_select') ? 'checked' : '' }}>
                        <label class="form-check-label" for="auto_select">Auto-select required component</label>
                    </div>
                </div>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="active" name="active" value="1" 
                       {{ old('active', true) ? 'checked' : '' }}>
                <label class="form-check-label" for="active">Active (rule is enforced)</label>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.rules.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Create Rule
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Prevent selecting the same component for both trigger and target
document.addEventListener('DOMContentLoaded', function() {
    const triggerSelect = document.getElementById('trigger_component_id');
    const targetSelect = document.getElementById('target_component_id');
    
    function updateOptions() {
        const triggerValue = triggerSelect.value;
        const targetValue = targetSelect.value;
        
        // Enable all options
        Array.from(targetSelect.options).forEach(option => {
            option.disabled = false;
        });
        
        // Disable the selected trigger option in target select
        if (triggerValue) {
            const triggerOption = targetSelect.querySelector(`option[value="${triggerValue}"]`);
            if (triggerOption) {
                triggerOption.disabled = true;
                if (targetValue === triggerValue) {
                    targetSelect.value = '';
                }
            }
        }
        
        // Do the same for trigger select
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
    
    // Initial update
    updateOptions();
});
</script>
@endpush
@endsection