@extends('layouts.admin-layout')

@section('title', 'Create Meal')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-plus-circle"></i> Add New Meal</h2>
</div>

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header" style="background: linear-gradient(135deg, #27ae60 0%, #229954 100%); color: white;">
                <h5 class="mb-0"><i class="fas fa-utensils"></i> Meal Details</h5>
            </div>
            <div class="card-body p-4">
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <h6><i class="fas fa-exclamation-triangle"></i> Please fix the following errors:</h6>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <form method="POST" action="{{ route('meals.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-4">
                                <label for="name" class="form-label">
                                    <i class="fas fa-hamburger"></i> Meal Name <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    class="form-control form-control-lg @error('name') is-invalid @enderror"
                                    placeholder="e.g., Margherita Pizza"
                                    value="{{ old('name') }}"
                                    required
                                >
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label">
                                    <i class="fas fa-align-left"></i> Description <span class="text-danger">*</span>
                                </label>
                                <textarea
                                    name="description"
                                    id="description"
                                    class="form-control @error('description') is-invalid @enderror"
                                    rows="4"
                                    placeholder="Describe the meal..."
                                    required
                                >{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="price" class="form-label">
                                        <i class="fas fa-dollar-sign"></i> Price <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="number"
                                        name="price"
                                        id="price"
                                        class="form-control form-control-lg @error('price') is-invalid @enderror"
                                        placeholder="0.00"
                                        step="0.01"
                                        value="{{ old('price') }}"
                                        required
                                    >
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="category_id" class="form-label">
                                        <i class="fas fa-list"></i> Category <span class="text-danger">*</span>
                                    </label>
                                    <select
                                        name="category_id"
                                        id="category_id"
                                        class="form-select form-select-lg @error('category_id') is-invalid @enderror"
                                        required
                                    >
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="image" class="form-label">
                                    <i class="fas fa-image"></i> Meal Image
                                </label>
                                <div class="card text-center p-3" style="border: 2px dashed #ddd;">
                                    <div id="imagePreview" class="mb-3" style="min-height: 200px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 8px;">
                                        <i class="fas fa-cloud-upload-alt fa-3x text-muted"></i>
                                    </div>
                                    <input
                                        type="file"
                                        name="image"
                                        id="image"
                                        class="form-control @error('image') is-invalid @enderror"
                                        accept="image/*"
                                        onchange="previewImage(event)"
                                    >
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted mt-2">
                                        <i class="fas fa-info-circle"></i> JPG, PNG, JPEG (Max: 2MB)
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-save"></i> Save Meal
                        </button>
                        <a href="{{ route('meals.index') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const preview = document.getElementById('imagePreview');
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" style="max-width: 100%; max-height: 200px; border-radius: 8px; object-fit: cover;">`;
        }
        reader.readAsDataURL(file);
    }
}
</script>

<style>
    .form-control:focus, .form-select:focus {
        border-color: #27ae60;
        box-shadow: 0 0 0 0.2rem rgba(39, 174, 96, 0.25);
    }
</style>
@endsection
