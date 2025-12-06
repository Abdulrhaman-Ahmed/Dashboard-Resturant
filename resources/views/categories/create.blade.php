@extends('layouts.admin-layout')

@section('title', 'Create Category')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-plus-circle"></i> Add New Category</h2>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header" style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); color: white;">
                <h5 class="mb-0"><i class="fas fa-file-alt"></i> Category Details</h5>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('categories.store') }}">
                    @csrf

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
                            value="{{ old('name') }}"
                            required
                            autofocus
                        >
                        @error('name')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle"></i> The slug will be generated automatically
                        </small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Save Category
                        </button>
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-4" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); color: white;">
            <div class="card-body">
                <h6><i class="fas fa-lightbulb"></i> Tips:</h6>
                <ul class="mb-0">
                    <li>Choose clear and descriptive category names</li>
                    <li>Keep category names short and memorable</li>
                    <li>Use proper capitalization (e.g., "Pizza" not "pizza")</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
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
