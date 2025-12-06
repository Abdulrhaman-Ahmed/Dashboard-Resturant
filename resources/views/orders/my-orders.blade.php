<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="{{ asset('Bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }
        .orders-container {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        .order-card {
            border: 2px solid #ecf0f1;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        .order-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        .status-badge {
            padding: 8px 15px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
        }
        .status-pending { background: #f39c12; color: white; }
        .status-processing { background: #3498db; color: white; }
        .status-completed { background: #27ae60; color: white; }
        .status-cancelled { background: #e74c3c; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <div class="text-center mb-4">
            <h1 class="text-white"><i class="fas fa-receipt"></i> My Orders</h1>
            <a href="{{ route('home') }}" class="btn btn-light mt-2">
                <i class="fas fa-arrow-left"></i> Back to Home
            </a>
        </div>

        <div class="orders-container">
            @forelse($orders as $order)
            <div class="order-card">
                <div class="row align-items-center">
                    <div class="col-md-2">
                        <h5 class="mb-1">Order #{{ $order->id }}</h5>
                        <small class="text-muted">{{ $order->created_at->format('M d, Y') }}</small>
                    </div>
                    <div class="col-md-3">
                        <strong>Items:</strong> {{ $order->items->count() }}<br>
                        <small class="text-muted">{{ $order->items->sum('quantity') }} total quantity</small>
                    </div>
                    <div class="col-md-2">
                        <strong class="text-success">${{ number_format($order->total_amount, 2) }}</strong>
                    </div>
                    <div class="col-md-3">
                        <span class="status-badge status-{{ $order->status }}">
                            @if($order->status == 'pending')
                                <i class="fas fa-clock"></i> Pending
                            @elseif($order->status == 'processing')
                                <i class="fas fa-spinner"></i> Processing
                            @elseif($order->status == 'completed')
                                <i class="fas fa-check"></i> Completed
                            @else
                                <i class="fas fa-times"></i> Cancelled
                            @endif
                        </span>
                    </div>
                    <div class="col-md-2 text-end">
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i> View Details
                        </a>
                    </div>
                </div>

                <hr class="my-3">

                <div class="order-items">
                    <strong>Items:</strong><br>
                    @foreach($order->items->take(3) as $item)
                    <small class="text-muted">
                        • {{ $item->meal_name }} (×{{ $item->quantity }})
                    </small><br>
                    @endforeach
                    @if($order->items->count() > 3)
                    <small class="text-muted">...and {{ $order->items->count() - 3 }} more</small>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                <h5>No orders yet</h5>
                <p class="text-muted">Start ordering delicious meals!</p>
                <a href="{{ route('home') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-utensils"></i> Browse Menu
                </a>
            </div>
            @endforelse
        </div>
    </div>

    <script src="{{ asset('Bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
