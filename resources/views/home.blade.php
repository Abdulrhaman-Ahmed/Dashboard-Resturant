<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Menu</title>
    <link rel="stylesheet" href="{{ asset('Bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <style>
        :root {
            --primary-color: #e74c3c;
            --secondary-color: #2c3e50;
            --accent-color: #f39c12;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }

        .hero-section {
            background: linear-gradient(135deg, rgba(231, 76, 60, 0.9) 0%, rgba(192, 57, 43, 0.9) 100%);
            color: white;
            padding: 60px 0;
            border-radius: 20px;
            margin-bottom: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            text-align: center;
        }

        .hero-section h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .hero-section p {
            font-size: 1.3rem;
            opacity: 0.95;
        }

        .category-filter {
            background: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 40px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .category-filter h5 {
            color: var(--secondary-color);
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .category-btn {
            margin: 5px;
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .category-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .btn-outline-dark:hover {
            background: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .meal-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transition: all 0.4s ease;
            height: 100%;
            border: none;
        }

        .meal-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
        }

        .meal-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .meal-card:hover img {
            transform: scale(1.1);
        }

        .meal-card .card-body {
            padding: 25px;
        }

        .meal-card .card-title {
            color: var(--secondary-color);
            font-weight: 700;
            font-size: 1.4rem;
            margin-bottom: 15px;
        }

        .meal-card .card-text {
            color: #7f8c8d;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .price-tag {
            background: linear-gradient(135deg, var(--primary-color) 0%, #c0392b 100%);
            color: white;
            padding: 10px 20px;
            border-radius: 50px;
            font-size: 1.3rem;
            font-weight: 700;
            display: inline-block;
            box-shadow: 0 4px 10px rgba(231, 76, 60, 0.3);
        }

        .category-badge {
            background: var(--accent-color);
            color: white;
            padding: 8px 15px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-block;
            margin-top: 10px;
        }

        .empty-state {
            background: white;
            padding: 80px 40px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .empty-state i {
            color: #bdc3c7;
            margin-bottom: 20px;
        }

        .empty-state h5 {
            color: var(--secondary-color);
            font-weight: 700;
        }

        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 2.5rem;
            }

            .meal-card img {
                height: 200px;
            }
        }

        .img-container {
            overflow: hidden;
            height: 250px;
            background: #f8f9fa;
        }

        .navbar-custom {
            background: white;
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            border-radius: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="navbar-custom">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0" style="color: var(--secondary-color);">
                        <i class="fas fa-utensils"></i> Restaurant
                    </h3>
                    @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">
                        <i class="fas fa-cog"></i> Admin Panel
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                    @endauth
                    <a href="{{ route('cart.index') }}" class="btn btn-warning position-relative">
                        <i class="fas fa-shopping-cart"></i> Cart
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cart-count">
                            0
                        </span>
                    </a>
                </div>
            </div>
        </div>

        <div class="hero-section">
            <h1><i class="fas fa-star"></i> Our Delicious Menu <i class="fas fa-star"></i></h1>
            <p>Discover amazing flavors from around the world</p>
        </div>

        <div class="category-filter">
            <h5>
                <i class="fas fa-filter"></i> Filter by Category
            </h5>
            <div class="d-flex flex-wrap justify-content-center">
                <a href="{{ route('home') }}" class="btn btn-outline-secondary category-btn">
                    <i class="fas fa-th"></i> Show All
                </a>
                @foreach($categories as $category)
                <a href="{{ route('category.filter', $category->id) }}" class="btn btn-outline-dark category-btn">
                    <i class="fas fa-tag"></i> {{ $category->name }}
                </a>
                @endforeach
            </div>
        </div>

        <div class="row g-4">
            @forelse($meals as $meal)
            <div class="col-md-6 col-lg-4">
                <div class="card meal-card">
                    <div class="img-container">
                        @if($meal->image)
                        <img src="{{ asset('storage/' . $meal->image) }}" class="card-img-top" alt="{{ $meal->name }}">
                        @else
                        <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                            <i class="fas fa-image fa-4x text-muted"></i>
                        </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $meal->name }}</h5>
                        <p class="card-text">{{ Str::limit($meal->description, 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="price-tag">
                                <i class="fas fa-dollar-sign"></i>{{ number_format($meal->price, 2) }}
                            </div>
                            <div class="category-badge">
                                <i class="fas fa-bookmark"></i> {{ $meal->category->name }}
                            </div>
                        </div>
                        <form action="{{ route('cart.add', $meal->id) }}" method="POST" class="mt-3">
                            @csrf
                            <button type="submit" class="btn btn-warning w-100 btn-lg">
                                <i class="fas fa-cart-plus"></i> Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="empty-state">
                    <i class="fas fa-utensils fa-5x"></i>
                    <h5 class="mt-3">No meals available for this category</h5>
                    <p class="text-muted">Try selecting a different category or check back later</p>
                    <a href="{{ route('home') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-arrow-left"></i> View All Meals
                    </a>
                </div>
            </div>
            @endforelse
        </div>

        <div class="text-center mt-5 mb-4">
            <div class="card" style="background: rgba(255,255,255,0.95); border: none; border-radius: 15px; padding: 30px;">
                <h5 style="color: var(--secondary-color);">
                    <i class="fas fa-heart text-danger"></i> Thank you for choosing us!
                </h5>
                <p class="text-muted mb-0">We serve fresh, delicious meals every day</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Update cart count
        function updateCartCount() {
            fetch('{{ route("cart.count") }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('cart-count').textContent = data.count;
                });
        }

        // Update on page load
        updateCartCount();
    </script>
</body>
</html>
