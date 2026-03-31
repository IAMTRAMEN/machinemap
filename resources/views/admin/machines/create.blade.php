@extends('layouts.admin')

@section('title', 'Add New Machine - MK Gilze Africa')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Add New Machine</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.machines.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Machines
        </a>
    </div>
</div>

<div class="card shadow">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.machines.store') }}">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Machine Code *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required>
                        <div class="form-text">Unique identifier (e.g., R230, R240)</div>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="display_name" class="form-label">Display Name *</label>
                        <input type="text" class="form-control @error('display_name') is-invalid @enderror" 
                               id="display_name" name="display_name" value="{{ old('display_name') }}" required>
                        <div class="form-text">User-friendly name for display</div>
                        @error('display_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description *</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="base_price" class="form-label">Base Price (€) *</label>
                        <input type="number" step="0.01" class="form-control @error('base_price') is-invalid @enderror" 
                               id="base_price" name="base_price" value="{{ old('base_price') }}" required>
                        @error('base_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="image_url" class="form-label">Image URL</label>
                        <input type="url" class="form-control @error('image_url') is-invalid @enderror" 
                               id="image_url" name="image_url" value="{{ old('image_url') }}">
                        <div class="form-text">Optional image URL for the machine</div>
                        @error('image_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Specifications (JSON)</label>
                <textarea class="form-control @error('specifications') is-invalid @enderror" 
                          id="specifications" name="specifications" rows="4" 
                          placeholder='{"Film Width": "320mm", "Max Cycles": "10/min", "Power Supply": "380V"}'>{{ old('specifications') }}</textarea>
                <div class="form-text">Enter specifications as JSON key-value pairs</div>
                @error('specifications')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label">Compatible Components</label>
                <div class="card">
                    <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                        @foreach($components as $component)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" 
                                   name="components[]" value="{{ $component->id }}" 
                                   id="component-{{ $component->id }}"
                                   {{ in_array($component->id, old('components', [])) ? 'checked' : '' }}>
                            <label class="form-check-label w-100" for="component-{{ $component->id }}">
                                <strong>{{ $component->name }}</strong> 
                                <small class="text-muted">({{ $component->code }}) - €{{ number_format($component->price, 2) }}</small>
                                <br>
                                <small class="text-muted">{{ $component->description }}</small>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="active" name="active" value="1" 
                       {{ old('active', true) ? 'checked' : '' }}>
                <label class="form-check-label" for="active">Active (available in configurator)</label>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.machines.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Create Machine
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Simple JSON validation for specifications
document.getElementById('specifications').addEventListener('blur', function(e) {
    try {
        if (e.target.value.trim()) {
            JSON.parse(e.target.value);
        }
    } catch (error) {
        alert('Invalid JSON format for specifications. Please check your input.');
        e.target.focus();
    }
});
</script>
@endpush
@endsection