<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Modern Header Styles */
        .navbar-brand {
            font-weight: bold;
            color: #1F2937 !important;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
        }

        .nav-link {
            color: #6B7280 !important;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #3B82F6 !important;
            background: rgba(59, 130, 246, 0.1) !important;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 2px;
            background: #3B82F6;
            border-radius: 1px;
        }

        /* Button Styles */
        .btn-primary {
            background: linear-gradient(135deg, #3B82F6 0%, #8B5CF6 100%);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2563EB 0%, #7C3AED 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
        }

        .btn-outline-primary {
            border-color: #3B82F6;
            color: #3B82F6;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: #3B82F6;
            border-color: #3B82F6;
            transform: translateY(-2px);
        }

        /* Dropdown Styles */
        .dropdown-menu {
            border: none;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border-radius: 12px !important;
        }

        .dropdown-item:hover {
            background: rgba(59, 130, 246, 0.1);
            color: #3B82F6;
        }

        /* Footer Styles */
        .text-white-75 {
            color: rgba(255, 255, 255, 0.75) !important;
        }

        .hover-primary:hover {
            color: #3B82F6 !important;
            transition: all 0.3s ease;
        }

        /* Form Styles */
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.15) !important;
            border-color: #3B82F6;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
            color: white;
        }

        /* Course Card Styles */
        .course-card {
            transition: transform 0.3s ease;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        /* Category Card Styles */
        .category-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
        }
        .category-card:hover {
            background: #e9ecef;
            transform: translateY(-3px);
        }

        /* Category link styles */
        a .category-card {
            transition: all 0.3s ease;
        }

        a:hover .category-card {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
        }

        a:hover .category-card .fa-arrow-right {
            transform: translateX(5px);
            transition: all 0.3s ease;
        }

        a .category-card h4,
        a .category-card p {
            transition: all 0.3s ease;
        }

        a:hover .category-card h4 {
            color: #3B82F6 !important;
        }

        /* Smooth Scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Sticky Header */
        .sticky-top {
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .navbar-nav {
                text-align: center;
                padding: 1rem 0;
            }

            .d-flex.gap-2 {
                flex-direction: column;
                gap: 0.5rem !important;
                width: 100%;
                padding: 1rem;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body class="font-sans antialiased">
    <!-- Navigation - Modern Header như React -->
    <header class="bg-white shadow-sm border-bottom sticky-top">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <!-- Logo & Brand -->
                <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                    <div class="d-flex align-items-center justify-content-center rounded-3 me-3"
                         style="width: 40px; height: 40px; background: linear-gradient(135deg, #3B82F6 0%, #8B5CF6 100%);">
                        <i class="fas fa-graduation-cap text-white"></i>
                    </div>
                    <span class="fw-bold fs-4" style="color: #1F2937;">EnglishPro</span>
                </a>

                <!-- Mobile Toggle -->
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <!-- Main Navigation -->
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link fw-semibold px-3 py-2 rounded-3 {{ request()->routeIs('home') ? 'active' : '' }}"
                               href="{{ route('home') }}">Trang Chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold px-3 py-2 rounded-3 {{ request()->routeIs('courses.*') ? 'active' : '' }}"
                               href="{{ route('courses.index') }}">Khóa Học</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold px-3 py-2 rounded-3 {{ request()->routeIs('discussions.*') ? 'active' : '' }}"
                               href="{{ route('discussions.index') }}">Thảo Luận</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold px-3 py-2 rounded-3" href="#about">Về Chúng Tôi</a>
                        </li>
                        @auth
                            <li class="nav-item">
                                <a class="nav-link fw-semibold px-3 py-2 rounded-3 {{ request()->routeIs('courses.my') ? 'active' : '' }}"
                                   href="{{ route('courses.my') }}">Khóa Học Của Tôi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-semibold px-3 py-2 rounded-3 {{ request()->routeIs('leaderboard.*') ? 'active' : '' }}"
                                   href="{{ route('leaderboard.index') }}">
                                    <i class="fas fa-trophy me-1"></i>Bảng Xếp Hạng
                                </a>
                            </li>
                        @endauth
                    </ul>

                    <!-- Auth Buttons -->
                    <div class="d-flex align-items-center gap-2">
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-3 px-4 py-2">
                                Đăng Nhập
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-primary rounded-3 px-4 py-2">
                                Đăng Ký
                            </a>
                        @else
                            <!-- User Dropdown -->
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle rounded-3 px-3 py-2 d-flex align-items-center"
                                        type="button" data-bs-toggle="dropdown">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2"
                                         style="width: 32px; height: 32px;">
                                        <span class="text-white fw-bold small">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    </div>
                                    <span class="fw-semibold">{{ Auth::user()->name }}</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2">
                                    <li>
                                        <a class="dropdown-item py-2 px-3 rounded-2" href="{{ route('dashboard') }}">
                                            <i class="fas fa-tachometer-alt me-2 text-primary"></i>Dashboard
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-2 px-3 rounded-2" href="{{ route('profile.edit') }}">
                                            <i class="fas fa-user me-2 text-success"></i>Hồ Sơ
                                        </a>
                                    </li>
                                    @if(Auth::user()->isAdmin())
                                        <li><hr class="dropdown-divider my-2"></li>
                                        <li>
                                            <a class="dropdown-item py-2 px-3 rounded-2" href="{{ route('admin.dashboard') }}">
                                                <i class="fas fa-cog me-2 text-warning"></i>Quản Trị
                                            </a>
                                        </li>
                                    @endif
                                    <li><hr class="dropdown-divider my-2"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item py-2 px-3 rounded-2 text-danger">
                                                <i class="fas fa-sign-out-alt me-2"></i>Đăng Xuất
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer - Modern Footer như React -->
    <footer style="background: linear-gradient(135deg, #1F2937 0%, #374151 100%); color: white;">
        <!-- Newsletter Section -->
        <div class="py-5" style="background: rgba(255,255,255,0.05);">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-8">
                        <h3 class="fw-bold mb-3">Đăng Ký Nhận Thông Tin Mới Nhất</h3>
                        <p class="text-white-75 mb-4">Nhận các bài học, tips học tiếng Anh và thông tin khóa học mới nhất từ chúng tôi</p>

                        <form class="d-flex justify-content-center gap-3 flex-wrap">
                            <div class="flex-grow-1" style="max-width: 400px;">
                                <input type="email" class="form-control form-control-lg rounded-3 border-0"
                                       placeholder="Nhập email của bạn" style="background: rgba(255,255,255,0.1); color: white;">
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg px-4 rounded-3">
                                <i class="fas fa-paper-plane me-2"></i>Đăng Ký
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Footer Content -->
        <div class="py-5">
            <div class="container">
                <div class="row g-4">
                    <!-- Company Info -->
                    <div class="col-lg-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="d-flex align-items-center justify-content-center rounded-3 me-3"
                                 style="width: 40px; height: 40px; background: linear-gradient(135deg, #3B82F6 0%, #8B5CF6 100%);">
                                <i class="fas fa-graduation-cap text-white"></i>
                            </div>
                            <span class="fw-bold fs-4">EnglishPro</span>
                        </div>
                        <p class="text-white-75 mb-4">
                            Nền tảng học tiếng Anh trực tuyến hàng đầu Việt Nam, cam kết mang đến
                            phương pháp học hiện đại và hiệu quả nhất cho học viên.
                        </p>

                        <!-- Contact Info -->
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-map-marker-alt me-3 text-primary"></i>
                                <span class="text-white-75">123 Đường ABC, Quận 1, TP.HCM</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-phone me-3 text-primary"></i>
                                <span class="text-white-75">+84 (028) 1234 5678</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-envelope me-3 text-primary"></i>
                                <span class="text-white-75">contact@englishpro.com</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="col-lg-2">
                        <h5 class="fw-bold mb-4">Liên Kết Nhanh</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <a href="#" class="text-white-75 text-decoration-none hover-primary">Về Chúng Tôi</a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ route('courses.index') }}" class="text-white-75 text-decoration-none hover-primary">Khóa Học</a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-white-75 text-decoration-none hover-primary">Giảng Viên</a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-white-75 text-decoration-none hover-primary">Blog</a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-white-75 text-decoration-none hover-primary">Liên Hệ</a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-white-75 text-decoration-none hover-primary">Tuyển Dụng</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Support -->
                    <div class="col-lg-2">
                        <h5 class="fw-bold mb-4">Hỗ Trợ</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <a href="#" class="text-white-75 text-decoration-none hover-primary">Trung Tâm Trợ Giúp</a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-white-75 text-decoration-none hover-primary">Hướng Dẫn Sử Dụng</a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-white-75 text-decoration-none hover-primary">Chính Sách Bảo Mật</a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-white-75 text-decoration-none hover-primary">Điều Khoản Dịch Vụ</a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-white-75 text-decoration-none hover-primary">Hoàn Tiền</a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-white-75 text-decoration-none hover-primary">FAQ</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Categories -->
                    <div class="col-lg-2">
                        <h5 class="fw-bold mb-4">Danh Mục</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <a href="#" class="text-white-75 text-decoration-none hover-primary">Giao Tiếp</a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-white-75 text-decoration-none hover-primary">Thương Mại</a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-white-75 text-decoration-none hover-primary">IELTS</a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-white-75 text-decoration-none hover-primary">TOEIC</a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-white-75 text-decoration-none hover-primary">Ngữ Pháp</a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-white-75 text-decoration-none hover-primary">Từ Vựng</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Social & Apps -->
                    <div class="col-lg-2">
                        <h5 class="fw-bold mb-4">Kết Nối</h5>
                        <div class="d-flex gap-3 mb-4">
                            <a href="#" class="text-white-75 hover-primary">
                                <i class="fab fa-facebook fa-lg"></i>
                            </a>
                            <a href="#" class="text-white-75 hover-primary">
                                <i class="fab fa-youtube fa-lg"></i>
                            </a>
                            <a href="#" class="text-white-75 hover-primary">
                                <i class="fab fa-instagram fa-lg"></i>
                            </a>
                            <a href="#" class="text-white-75 hover-primary">
                                <i class="fab fa-tiktok fa-lg"></i>
                            </a>
                        </div>

                        <h6 class="fw-bold mb-3">Tải Ứng Dụng</h6>
                        <div class="d-flex flex-column gap-2">
                            <a href="#" class="btn btn-outline-light btn-sm rounded-3">
                                <i class="fab fa-apple me-2"></i>App Store
                            </a>
                            <a href="#" class="btn btn-outline-light btn-sm rounded-3">
                                <i class="fab fa-google-play me-2"></i>Google Play
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="py-4 border-top border-white border-opacity-10">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p class="mb-0 text-white-75">© {{ date('Y') }} EnglishPro. Tất cả quyền được bảo lưu.</p>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-md-end gap-3">
                            <a href="#" class="text-white-75 hover-primary">
                                <i class="fab fa-facebook"></i>
                            </a>
                            <a href="#" class="text-white-75 hover-primary">
                                <i class="fab fa-youtube"></i>
                            </a>
                            <a href="#" class="text-white-75 hover-primary">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="text-white-75 hover-primary">
                                <i class="fab fa-tiktok"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Scripts -->
    @stack('scripts')
</body>
</html>
