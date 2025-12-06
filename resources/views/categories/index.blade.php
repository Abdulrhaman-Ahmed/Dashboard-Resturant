@extends('layouts.admin-layout')

@section('title', 'Categories')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <h2><i class="fas fa-list"></i> Categories Management</h2>
        <a href="{{ route('categories.create') }}" class="btn btn-light btn-lg">
            <i class="fas fa-plus-circle"></i> Add New Category
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card">
    <div class="card-body">
        @if($categories->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 35%">Name</th>
                        <th style="width: 35%">Slug</th>
                        <th style="width: 10%" class="text-center">Meals Count</th>
                        <th style="width: 15%" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $index => $category)
                    <tr>
                        <td><strong>{{ $index + 1 }}</strong></td>
                        <td>
                            <i class="fas fa-tag text-primary"></i>
                            <strong>{{ $category->name }}</strong>
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $category->slug }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-info rounded-pill">{{ $category->meals->count() }}</span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
            <h5 class="text-muted">No categories found</h5>
            <p>Start by adding your first category</p>
            <a href="{{ route('categories.create') }}" class="btn btn-primary mt-3">
                <i class="fas fa-plus-circle"></i> Add Category
            </a>
        </div>
        @endif
    </div>
</div>

<style>
    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: rgba(52, 152, 219, 0.1);
        transform: scale(1.01);
    }

    .btn-group .btn {
        margin: 0 2px;
    }
</style>
@endsection
