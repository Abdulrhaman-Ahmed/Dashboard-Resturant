<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
        <link rel="stylesheet" href="{{ asset('Bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #e74c3c;
            --accent-color: #3498db;
            --sidebar-bg: #34495e;
            --hover-color: #2980b9;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #ecf0f1;
        }

        .sidebar {
            background: linear-gradient(180deg, var(--sidebar-bg) 0%, var(--primary-color) 100%);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }

        .sidebar h4 {
            color: #fff;
            font-weight: 700;
            padding: 25px 0;
            margin: 0;
            border-bottom: 2px solid rgba(255,255,255,0.1);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .main-content {
            margin-left: 260px;
            padding: 30px;
        }

        .page-header {
            background: linear-gradient(135deg, var(--accent-color) 0%, var(--hover-color) 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .page-header h2 {
            margin: 0;
            font-weight: 700;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }



        .btn-logout:hover {
            background: #c0392b;
            transform: scale(1.05);
        }

        .table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }

        .table thead {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--sidebar-bg) 100%);
            color: white;
        }

        .btn-primary {
            background: var(--accent-color);
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: var(--hover-color);
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                min-height: auto;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <nav class="sidebar">
        <div class="text-center">
            <h4 class="text-center"><i class="fas fa-utensils"></i> Restaurant</h4>
            <div class="text-center text-white">
             <h5 > Welcome, {{ Auth::user()->name }}!</h5>
            <h6>Thank you for choosing us!</h6>
            </div>

        </div>
        </nav>
        <div class="main-content">
                @yield('content')
            </div>
    <script src="{{ asset('Bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
