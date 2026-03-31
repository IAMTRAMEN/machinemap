{{-- resources/views/admin/categories/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Edit Category</h1>
        <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Category
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Category Name *</label>
                    <input type="text" name="name" id="name" 
                           class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name', $category->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" 
                              class="form-control @error('description') is-invalid @enderror" 
                              rows="3">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="order" class="form-label">Order</label>
                    <input type="number" name="order" id="order" 
                           class="form-control @error('order') is-invalid @enderror" 
                           value="{{ old('order', $category->order) }}">
                    <small class="text-muted">Lower numbers appear first</small>
                    @error('order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection