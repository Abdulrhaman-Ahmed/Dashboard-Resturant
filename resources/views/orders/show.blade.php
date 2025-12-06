@extends('layouts.user-layout')

@section('title', 'Order Details')

@push('styles')

@endpush

@section('content')
<div class="container">
    <div class="card">
        <div class="header d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-shopping-bag me-2 m-2"></i>Order Details</h4>
            <span class="order-badge">#{{ $order->id }}</span>
        </div>
        <div class="card-body p-4">
                    <!-- Order Status and Date -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y h:i A') }}</p>
                            <p><strong>Status:</strong>
                                <span class="badge bg-{{
                                    $order->status === 'completed' ? 'success' :
                                    ($order->status === 'cancelled' ? 'danger' :
                                    ($order->status === 'processing' ? 'info' : 'warning'))
                                }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p><strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div class="mb-4">
                        <h5 class="mb-3">Customer Information</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Name:</strong> {{ $order->customer_name }}</p>
                                <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
                                <p><strong>Address:</strong> {{ $order->customer_address }}</p>
                            </div>
                        </div>
                        @if($order->notes)
                        <div class="mt-2">
                            <p><strong>Notes:</strong> {{ $order->notes }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Order Items -->
                    <div class="mb-4">
                        <h5 class="mb-3">Order Items</h5>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td>{{ $item->meal_name }}</td>
                                        <td>${{ number_format($item->price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>${{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-end">Total:</th>
                                        <th>${{ number_format($order->total_amount, 2) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('orders.my') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to My Orders
                        </a>

                        @if($order->status === 'pending')
                        <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-times-circle me-2"></i>Cancel Order
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
