@extends('layouts.admin-layout')

@section('title', 'Edit Category')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-edit"></i> Edit Category</h2>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); color: white;">
                <h5 class="mb-0"><i class="fas fa-file-alt"></i> Update Category Details</h5>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('categories.update', $category) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="form-label">
                            <i class="fas fa-tag"></i> Category Name <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="form-control form-control-lg @error('name') is-invalid @enderror"
                            placeholder="e.g., Pizza, Burgers, Drinks"
                            value="{{ old('name', $category->name) }}"
                            required
                            autofocus
                        >
                        @error('name')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">
                            <i class="fas fa-link"></i> Current Slug
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            value="{{ $category->slug }}"
                            disabled
                        >
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle"></i> Slug will be updated automatically based on the new name
                        </small>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Note:</strong> This category has {{ $category->meals->count() }} meal(s) associated with it.
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-check"></i> Update Category
                        </button>
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-4" style="border-left: 4px solid #e74c3c;">
            <div class="card-body">
                <h6 class="text-danger"><i class="fas fa-exclamation-triangle"></i> Danger Zone</h6>
                <p class="text-muted mb-3">Deleting this category will also delete all associated meals.</p>
                <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure? This will delete all meals in this category!')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Delete Category
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: #f39c12;
        box-shadow: 0 0 0 0.2rem rgba(243, 156, 18, 0.25);
    }

    .btn {
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
</style>
@endsection
