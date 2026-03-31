{{-- resources/views/admin/categories/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Component Categories')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Component Categories</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Category
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($categories->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Components</th>
                            <th>Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>
                                <strong>{{ $category->name }}</strong>
                                @if($category->description)
                                    <br><small class="text-muted">{{ Str::limit($category->description, 50) }}</small>
                                @endif
                            </td>
                            <td>
                                <code>{{ $category->slug }}</code>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $category->components_count }}</span>
                            </td>
                            <td>{{ $category->order }}</td>
                            <td>
                                <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Are you sure you want to delete this category?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $categories->links() }}
            @else
            <div class="text-center py-4">
                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                <p class="text-muted">No categories found.</p>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                    Create First Category
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection