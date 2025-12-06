<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success</title>
    <link rel="stylesheet" href="{{ asset('Bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <style>
        body {
            background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
            min-height: 100vh;
            padding: 50px 0;
        }
        .success-container {
            background: white;
            border-radius: 20px;
            padding: 50px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            text-align: center;
        }
        .success-icon {
            font-size: 80px;
            color: #27ae60;
            animation: scaleIn 0.5s ease;
        }
        @keyframes scaleIn {
            0% { transform: scale(0); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        .order-details {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 15px;
            margin-top: 30px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="success-container">
                    <i class="fas fa-check-circle success-icon"></i>
                    <h1 class="mt-4">Order Placed Successfully!</h1>
                    <p class="text-muted">Thank you for your order. We'll start preparing it right away!</p>

                    <div class="alert alert-success mt-4">
                        <strong>Order ID:</strong> #{{ $order->id }}
                    </div>

                    <div class="order-details">
                        <h4 class="mb-4"><i class="fas fa-receipt"></i> Order Details</h4>

                        <div class="row mb-3">
                            <div class="col-6"><strong>Customer Name:</strong></div>
                            <div class="col-6">{{ $order->customer_name }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6"><strong>Email:</strong></div>
                            <div class="col-6">{{ $order->customer_email }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6"><strong>Phone:</strong></div>
                            <div class="col-6">{{ $order->customer_phone }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6"><strong>Delivery Address:</strong></div>
                            <div class="col-6">{{ $order->customer_address }}</div>
                        </div>

                        <hr>

                        <h5 class="mb-3">Items:</h5>
                        @foreach($order->items as $item)
                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ $item->meal_name }} × {{ $item->quantity }}</span>
                            <strong>${{ number_format($item->subtotal, 2) }}</strong>
                        </div>
                        @endforeach

                        <hr>

                        <div class="d-flex justify-content-between">
                            <h5>Total Amount:</h5>
                            <h5 class="text-success"><strong>${{ number_format($order->total_amount, 2) }}</strong></h5>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2 justify-content-center">
                        <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-home"></i> Back to Home
                        </a>
                        @auth
                        <a href="{{ route('orders.my') }}" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-list"></i> My Orders
                        </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('Bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
