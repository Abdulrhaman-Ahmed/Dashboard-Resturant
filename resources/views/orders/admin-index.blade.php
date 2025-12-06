@extends('layouts.admin-layout')

@section('title', 'Orders Management')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <h2><i class="fas fa-shopping-bag"></i> Orders Management</h2>
        <div>
            <span class="badge bg-warning">{{ $orders->where('status', 'pending')->count() }} Pending</span>
            <span class="badge bg-info">{{ $orders->where('status', 'processing')->count() }} Processing</span>
            <span class="badge bg-success">{{ $orders->where('status', 'completed')->count() }} Completed</span>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card">
    <div class="card-body">
        @if($orders->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr class="order-row">
                        <td><strong>#{{ $order->id }}</strong></td>
                        <td>
                            {{ $order->customer_name }}<br>
                            <small class="text-muted">{{ $order->customer_email }}</small>
                        </td>
                        <td>{{ $order->customer_phone }}</td>
                        <td>
                            <span class="badge bg-primary">{{ $order->items->count() }} items</span>
                        </td>
                        <td><strong class="text-success">${{ number_format($order->total_amount, 2) }}</strong></td>
                        <td>
                            <form action="{{ route('orders.update-status', $order->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()"
                                        style="width: auto;">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                        Processing
                                    </option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>
                                        Completed
                                    </option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                        Cancelled
                                    </option>
                                </select>
                            </form>
                        </td>
                        <td>
                            {{ $order->created_at->format('M d, Y') }}<br>
                            <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-info btn-sm toggle-details" data-order-id="{{ $order->id }}">
                                <i class="fas fa-eye"></i> View Details
                            </button>
                        </td>
                    </tr>

                    <!-- Expandable Details Row -->
                    <tr class="order-details-row" id="details-{{ $order->id }}" style="display: none;">
                        <td colspan="8" style="background-color: #f8f9fa; padding: 20px;">
                            <div class="row">
                                <!-- Customer Info -->
                                <div class="col-md-4 mb-3">
                                    <h6 class="border-bottom pb-2"><i class="fas fa-user"></i> Customer Info</h6>
                                    <p class="mb-1"><strong>Name:</strong> {{ $order->customer_name }}</p>
                                    <p class="mb-1"><strong>Email:</strong> {{ $order->customer_email }}</p>
                                    <p class="mb-1"><strong>Phone:</strong> {{ $order->customer_phone }}</p>
                                    <p class="mb-0"><strong>Address:</strong> {{ $order->customer_address }}</p>
                                </div>

                                <!-- Order Items -->
                                <div class="col-md-8">
                                    <h6 class="border-bottom pb-2"><i class="fas fa-list"></i> Order Items</h6>
                                    <table class="table table-sm table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Meal</th>
                                                <th>Price</th>
                                                <th>Qty</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order->items as $item)
                                            <tr>
                                                <td>{{ $item->meal_name }}</td>
                                                <td>${{ number_format($item->price, 2) }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td><strong>${{ number_format($item->subtotal, 2) }}</strong></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3" class="text-end">Total:</th>
                                                <th class="text-success">${{ number_format($order->total_amount, 2) }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>

                                    @if($order->notes)
                                    <div class="alert alert-info mt-2 mb-0">
                                        <strong><i class="fas fa-sticky-note"></i> Notes:</strong> {{ $order->notes }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-shopping-bag fa-4x text-muted mb-3"></i>
            <h5>No orders yet</h5>
            <p class="text-muted">Orders will appear here when customers place them</p>
        </div>
        @endif
    </div>
</div>

<style>
    .table tbody tr.order-row {
        transition: all 0.3s ease;
    }
    .table tbody tr.order-row:hover {
        background-color: rgba(52, 152, 219, 0.1);
        transform: scale(1.01);
    }
    .order-details-row {
        transition: all 0.3s ease;
    }
    .toggle-details.active i {
        transform: rotate(180deg);
        transition: transform 0.3s ease;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle order details
    document.querySelectorAll('.toggle-details').forEach(button => {
        button.addEventListener('click', function() {
            const orderId = this.getAttribute('data-order-id');
            const detailsRow = document.getElementById('details-' + orderId);

            if (detailsRow.style.display === 'none') {
                detailsRow.style.display = 'table-row';
                this.innerHTML = '<i class="fas fa-eye-slash"></i> Hide';
                this.classList.add('active');
            } else {
                detailsRow.style.display = 'none';
                this.innerHTML = '<i class="fas fa-eye"></i> View Details';
                this.classList.remove('active');
            }
        });
    });
});
</script>
@endsection
