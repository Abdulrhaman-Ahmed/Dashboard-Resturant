@extends('layouts.admin-layout')

@section('title', 'Meals')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <h2><i class="fas fa-hamburger"></i> Meals Management</h2>
        <a href="{{ route('meals.create') }}" class="btn btn-light btn-lg">
            <i class="fas fa-plus-circle"></i> Add New Meal
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
        @if($meals->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 15%">Image</th>
                        <th style="width: 25%">Name</th>
                        <th style="width: 15%">Category</th>
                        <th style="width: 10%" class="text-center">Price</th>
                        <th style="width: 25%">Description</th>
                        <th style="width: 15%" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($meals as $index => $meal)
                    <tr>
                        <td><strong>{{ $index + 1 }}</strong></td>
                        <td>
                            @if($meal->image)
                            <img src="{{ asset('storage/' . $meal->image) }}"
                                 alt="{{ $meal->name }}"
                                 class="rounded"
                                 style="width: 80px; height: 80px; object-fit: cover; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                            @else
                            <div class="bg-secondary rounded d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <i class="fas fa-image text-white fa-2x"></i>
                            </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $meal->name }}</strong>
                        </td>
                        <td>
                            <span class="badge bg-primary">
                                <i class="fas fa-tag"></i> {{ $meal->category->name }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-success" style="font-size: 1rem;">
                                ${{ number_format($meal->price, 2) }}
                            </span>
                        </td>
                        <td>
                            <small class="text-muted">{{ Str::limit($meal->description, 50) }}</small>
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('meals.edit', $meal) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('meals.destroy', $meal) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this meal?')">
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
            <i class="fas fa-utensils fa-4x text-muted mb-3"></i>
            <h5 class="text-muted">No meals found</h5>
            <p>Start by adding your first meal</p>
            <a href="{{ route('meals.create') }}" class="btn btn-primary mt-3">
                <i class="fas fa-plus-circle"></i> Add Meal
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
        background-color: rgba(231, 76, 60, 0.1);
        transform: scale(1.01);
    }

    .btn-group .btn {
        margin: 0 2px;
    }

    img {
        transition: transform 0.3s ease;
    }

    img:hover {
        transform: scale(1.1);
    }
</style>
@endsection
