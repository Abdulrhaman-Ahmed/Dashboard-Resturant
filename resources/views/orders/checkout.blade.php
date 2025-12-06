<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="{{ asset('Bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }
        .checkout-container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        .checkout-header {
            background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
            color: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
        }
        .order-item {
            border-bottom: 1px solid #ecf0f1;
            padding: 15px 0;
        }
        .order-summary {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            position: sticky;
            top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="checkout-header">
            <h1><i class="fas fa-credit-card"></i> Checkout</h1>
            <p class="mb-0">Complete your order</p>
        </div>

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

        <div class="row">
            <div class="col-lg-7">
                <div class="checkout-container">
                    <h4 class="mb-4"><i class="fas fa-user"></i> Customer Information</h4>

                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="customer_name" class="form-control form-control-lg"
                                   value="{{ old('customer_name', Auth::user()->name ?? '') }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="customer_email" class="form-control form-control-lg"
                                       value="{{ old('customer_email', Auth::user()->email ?? '') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="tel" name="customer_phone" class="form-control form-control-lg"
                                       value="{{ old('customer_phone') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Delivery Address <span class="text-danger">*</span></label>
                            <textarea name="customer_address" class="form-control" rows="3"
                                      required>{{ old('customer_address') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Order Notes (Optional)</label>
                            <textarea name="notes" class="form-control" rows="2"
                                      placeholder="Any special instructions...">{{ old('notes') }}</textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success btn-lg flex-grow-1">
                                <i class="fas fa-check"></i> Place Order
                            </button>
                            <a href="{{ route('cart.index') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="order-summary">
                    <h4 class="mb-4"><i class="fas fa-receipt"></i> Order Summary</h4>

                    @foreach($cartItems as $item)
                    <div class="order-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $item->meal->name }}</strong>
                                <br>
                                <small class="text-muted">Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</small>
                            </div>
                            <strong class="text-success">${{ number_format($item->subtotal, 2) }}</strong>
                        </div>
                    </div>
                    @endforeach

                    <div class="mt-4 pt-3 border-top">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <strong>${{ number_format($total, 2) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Delivery Fee:</span>
                            <strong class="text-success">Free</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h5>Total:</h5>
                            <h5 class="text-primary"><strong>${{ number_format($total, 2) }}</strong></h5>
                        </div>
                    </div>

                    <div class="alert alert-info mt-3 mb-0">
                        <i class="fas fa-info-circle"></i> <small>Payment on delivery</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('Bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>

