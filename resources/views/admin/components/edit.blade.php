@extends('layouts.admin')

@section('title', 'Edit Component - MK Gilze Africa')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Component: {{ $component->name }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.components.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Components
        </a>
    </div>
</div>

<div class="card shadow">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.components.update', $component) }}">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Component Name *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $component->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="code" class="form-label">Component Code *</label>
                        <input type="text" class="form-control @error('code') is-invalid @enderror" 
                               id="code" name="code" value="{{ old('code', $component->code) }}" required>
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Category *</label>
                <select class="form-select @error('category_id') is-invalid @enderror" 
                        id="category_id" name="category_id" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $component->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="3">{{ old('description', $component->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="price" class="form-label">Price (€) *</label>
                        <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                               id="price" name="price" value="{{ old('price', $component->price) }}" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="installation_time" class="form-label">Installation Time (hours) *</label>
                        <input type="number" class="form-control @error('installation_time') is-invalid @enderror" 
                               id="installation_time" name="installation_time" value="{{ old('installation_time', $component->installation_time) }}" required>
                        @error('installation_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="active" name="active" value="1" 
                       {{ old('active', $component->active) ? 'checked' : '' }}>
                <label class="form-check-label" for="active">Active (available in configurator)</label>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.components.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update Component
                </button>
            </div>
        </form>
    </div>
</div>
@endsection