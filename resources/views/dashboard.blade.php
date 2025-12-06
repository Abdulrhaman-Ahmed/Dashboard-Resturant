@extends('layouts.admin-layout')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-tachometer-alt"></i> Welcome to Admin Dashboard</h2>
    <p class="mb-0 mt-2">Manage your restaurant efficiently</p>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card text-center p-4" style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); color: white;">
            <div class="card-body">
                <i class="fas fa-list fa-3x mb-3"></i>
                <h3 class="card-title">{{ \App\Models\Category::count() }}</h3>
                <p class="card-text">Total Categories</p>
                <a href="{{ route('categories.index') }}" class="btn btn-light mt-2">
                    <i class="fas fa-eye"></i> View All
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-center p-4" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color: white;">
            <div class="card-body">
                <i class="fas fa-hamburger fa-3x mb-3"></i>
                <h3 class="card-title">{{ \App\Models\Meal::count() }}</h3>
                <p class="card-text">Total Meals</p>
                <a href="{{ route('meals.index') }}" class="btn btn-light mt-2">
                    <i class="fas fa-eye"></i> View All
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-center p-4" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); color: white;">
            <div class="card-body">
                <i class="fas fa-shopping-bag fa-3x mb-3"></i>
                <h3 class="card-title">{{ \App\Models\Order::count() }}</h3>
                <p class="card-text">Total Orders</p>
                <a href="{{ route('orders.admin') }}" class="btn btn-light mt-2">
                    <i class="fas fa-eye"></i> View All
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-6">
        <div class="card p-4">
            <h5 class="card-title mb-4"><i class="fas fa-chart-line"></i> Quick Actions</h5>
            <div class="d-grid gap-3">
                <a href="{{ route('categories.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus-circle"></i> Add New Category
                </a>
                <a href="{{ route('meals.create') }}" class="btn btn-success btn-lg">
                    <i class="fas fa-plus-circle"></i> Add New Meal
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card p-4">
            <h5 class="card-title mb-4"><i class="fas fa-clock"></i> Recent Activity</h5>
            <div class="list-group">
                @foreach(\App\Models\Meal::latest()->take(5)->get() as $meal)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-utensils text-primary"></i>
                        <strong>{{ $meal->name }}</strong>
                    </div>
                    <span class="badge bg-primary rounded-pill">${{ $meal->price }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-12">
        <div class="card p-4 text-center" style="background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%); color: white;">
            <h4><i class="fas fa-info-circle"></i> System Information</h4>
            <p class="mb-0">Laravel Restaurant Management System v1.0</p>
            <small>Developed for efficient restaurant operations</small>
        </div>
    </div>
</div>
@endsection
