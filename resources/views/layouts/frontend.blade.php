<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'العقارات') | اسم الموقع</title>
    
    <!-- Bootstrap RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #0a2640;
            color: #ffffff;
        }
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            background-color: #0a2640 !important;
        }
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }
        footer {
            background: #2c3e50;
            color: white;
            padding: 40px 0;
        }
        .navbar .nav-link,
        .navbar .navbar-brand {
            color: #ffffff !important;
        }
        .navbar .nav-link:hover {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        h1, h2, h3, h4, h5, h6 {
            color: #ffffff;
        }
        p {
            color: rgba(255, 255, 255, 0.9);
        }
        .card {
            background-color: #ffffff;
            color: #0a2640;
        }
        .card-title {
            color: #0a2640;
        }
        .card-text {
            color: #333;
        }
        a {
            color: #ffffff;
        }
        a:hover {
            color: rgba(255, 255, 255, 0.8);
        }
        /* Navbar Styles */
        .navbar {
            background-color: #0a2640 !important;
            padding: 1rem 0;
            transition: all 0.3s ease;
        }

        .logo-img {
            height: 40px;
        }

        .navbar-nav .nav-link {
            color: #ffffff !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            margin: 0 0.25rem;
        }

        .navbar-nav .nav-link:hover {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        /* Action Buttons */
        .nav-buttons .btn {
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-outline-light.rounded-circle {
            width: 40px;
            height: 40px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary {
            background-color: #4c1d95;
            border-color: #4c1d95;
        }

        .btn-primary:hover {
            background-color: #5b21b6;
            border-color: #5b21b6;
        }

        .btn-outline-primary {
            color: #ffffff;
            border-color: #ffffff;
        }

        .btn-outline-primary:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }

        /* Mobile Responsive */
        @media (max-width: 991.98px) {
            .nav-buttons {
                margin-top: 1rem;
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
            }

            .navbar-collapse {
                background-color: #0a2640;
                padding: 1rem;
                border-radius: 8px;
                margin-top: 1rem;
            }

            .navbar-nav {
                text-align: center;
            }
        }

        /* Add padding to body to prevent content from hiding under fixed navbar */
        body {
            padding-top: 80px;
        }
    </style>
    @stack('styles')
    <!-- إضافة SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="{{ route('frontend.home') }}">
                <img src="{{ asset('images/frontend/DALL·E 2024-11-25 21.55.28 - A professional and elegant logo design for a real estate website with a transparent background. The logo features a modern house icon with a sleek roo.webp') }}" alt="MENASSAT" class="logo-img">
            </a>

            <!-- Navigation Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('frontend.home') ? 'active' : '' }}" href="{{ route('frontend.home') }}">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Services
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Auctions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Offers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">News</a>
                    </li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="nav-buttons d-none d-lg-flex">
                <button class="btn btn-outline-light rounded-circle me-2">
                    <i class="fas fa-search"></i>
                </button>
                <a href="{{ route('frontend.market.create') }}" class="btn btn-primary px-4 me-2">Start marketing now</a>
                <a href="" class="btn btn-outline-primary px-4">Need service ?</a>
            </div>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5>عن الموقع</h5>
                    <p>موقع متخصص في بيع وشراء العقارات في مصر</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>روابط سريعة</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('frontend.home') }}" class="text-white">الرئيسية</a></li>
                        <li><a href="{{ route('frontend.search') }}" class="text-white">البحث</a></li>
                        <li><a href="#contact" class="text-white">اتصل بنا</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>تواصل معنا</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-phone me-2"></i> 123-456-789</li>
                        <li><i class="fas fa-envelope me-2"></i> info@example.com</li>
                        <li><i class="fas fa-map-marker-alt me-2"></i> القاهرة، مصر</li>
                    </ul>
                </div>
            </div>
            <hr class="bg-white">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} جميع الحقوق محفوظة</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- إضافة SweetAlert2 JS قبل نهاية body -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
</body>
</html>
