{{-- resources/views/admin/categories/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Category Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Category Details</h1>
        <div>
            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit Category
            </a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Categories
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Category Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Name</h6>
                            <p class="fs-5">{{ $category->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Slug</h6>
                            <p class="fs-5"><code>{{ $category->slug }}</code></p>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h6>Order</h6>
                            <p>{{ $category->order }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Components Count</h6>
                            <p><span class="badge bg-primary">{{ $category->components_count }}</span></p>
                        </div>
                    </div>

                    @if($category->description)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6>Description</h6>
                            <div class="border rounded p-3 bg-light">
                                {{ $category->description }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            @if($category->components->count() > 0)
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title">Components in this Category ({{ $category->components_count }})</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($category->components as $component)
                                <tr>
                                    <td>{{ $component->name }}</td>
                                    <td><code>{{ $component->code }}</code></td>
                                    <td>€{{ number_format($component->price, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $component->active ? 'success' : 'secondary' }}">
                                            {{ $component->active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.components.create') }}?category_id={{ $category->id }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> Add Component to this Category
                        </a>
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Category
                        </a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-grid">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">
                                <i class="fas fa-trash"></i> Delete Category
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title">Category Stats</h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="mb-3">
                            <i class="fas fa-folder fa-3x text-primary"></i>
                        </div>
                        <h5>{{ $category->name }}</h5>
                        <div class="mt-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Components:</span>
                                <strong>{{ $category->components_count }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Active Components:</span>
                                <strong>{{ $category->active_components_count }}</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Display Order:</span>
                                <strong>{{ $category->order }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection