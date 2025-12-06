<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="{{ asset('Bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }
        .cart-container {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        .cart-header {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
        }
        .cart-item {
            border: 2px solid #ecf0f1;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        .cart-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        .cart-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
        }
        .quantity-input {
            width: 80px;
            text-align: center;
        }
        .summary-box {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            position: sticky;
            top: 20px;
        }
        .btn-checkout {
            background: #27ae60;
            color: white;
            font-weight: 700;
            padding: 15px;
            border-radius: 10px;
            width: 100%;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-checkout:hover {
            background: #229954;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Navbar -->
        <div class="bg-white rounded-4 mb-4 p-3 shadow">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('home') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left"></i> Continue Shopping
                </a>
                @auth
                <a href="{{ route('orders.my') }}" class="btn btn-outline-success">
                    <i class="fas fa-receipt"></i> My Orders
                </a>
                @endauth
            </div>
        </div>

        <div class="cart-header text-center">
            <h1><i class="fas fa-shopping-cart"></i> Your Shopping Cart</h1>
            <p class="mb-0">{{ $cartItems->count() }} item(s) in your cart</p>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="row">
            <div class="col-lg-8">
                <div class="cart-container">
                    @forelse($cartItems as $item)
                    <div class="cart-item">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                @if($item->meal->image)
                                <img src="{{ asset('storage/' . $item->meal->image) }}" alt="{{ $item->meal->name }}">
                                @else
                                <div class="bg-secondary rounded d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                    <i class="fas fa-image text-white fa-2x"></i>
                                </div>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <h5 class="mb-1">{{ $item->meal->name }}</h5>
                                <small class="text-muted">{{ $item->meal->category->name }}</small>
                            </div>
                            <div class="col-md-2 text-center">
                                <strong class="text-primary">${{ number_format($item->price, 2) }}</strong>
                            </div>
                            <div class="col-md-2">
                                <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="input-group">
                                        <input type="number" name="quantity" value="{{ $item->quantity }}"
                                               min="1" max="99" class="form-control quantity-input"
                                               onchange="this.form.submit()">
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-2 text-end">
                                <strong class="text-success">${{ number_format($item->subtotal, 2) }}</strong>
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mt-2" onclick="return confirm('Remove this item?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                        <h4>Your cart is empty</h4>
                        <a href="{{ route('home') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-utensils"></i> Browse Meals
                        </a>
                    </div>
                    @endforelse

                    @if($cartItems->count() > 0)
                    <div class="text-end mt-3">
                        <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Clear entire cart?')">
                                <i class="fas fa-trash-alt"></i> Clear Cart
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>

            @if($cartItems->count() > 0)
            <div class="col-lg-4">
                <div class="summary-box">
                    <h4 class="mb-4"><i class="fas fa-calculator"></i> Order Summary</h4>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Subtotal:</span>
                        <strong>${{ number_format($total, 2) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Delivery:</span>
                        <strong>Free</strong>
                    </div>
                    <hr style="border-color: rgba(255,255,255,0.3);">
                    <div class="d-flex justify-content-between mb-4">
                        <h5>Total:</h5>
                        <h5><strong>${{ number_format($total, 2) }}</strong></h5>
                    </div>
                    <a href="{{ route('orders.checkout') }}" class="btn-checkout">
                        <i class="fas fa-credit-card"></i> Proceed to Checkout
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>

    <script src="{{ asset('Bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
