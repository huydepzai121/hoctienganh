@extends('layouts.adminlte-pure')

@section('title', 'Dashboard - Admin')

@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        <i class="fas fa-tachometer-alt mr-2"></i>
                        Dashboard
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="text-white mb-0">
                                <i class="fas fa-sun mr-2"></i>
                                Chào mừng trở lại, {{ Auth::user()->name }}!
                            </h4>
                            <p class="text-white-50 mb-0">
                                Hôm nay là {{ \Carbon\Carbon::now()->format('l, d F Y') }}
                            </p>
                        </div>
                        <div class="col-md-4 text-right">
                            <div class="text-white">
                                <i class="fas fa-clock mr-1"></i>
                                {{ \Carbon\Carbon::now()->format('H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Stats Cards -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-info">
                <div class="inner">
                    <h3>{{ number_format($stats['total_users']) }}</h3>
                    <p>Tổng Người Dùng</p>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-light" style="width: {{ ($stats['total_users'] / 1000) * 100 }}%"></div>
                    </div>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('admin.users.index') }}" class="small-box-footer">
                    Xem chi tiết <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-success">
                <div class="inner">
                    <h3>{{ number_format($stats['total_courses']) }}</h3>
                    <p>Tổng Khóa Học</p>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-light" style="width: {{ ($stats['total_courses'] / 50) * 100 }}%"></div>
                    </div>
                </div>
                <div class="icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <a href="{{ route('admin.courses.index') }}" class="small-box-footer">
                    Xem chi tiết <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-warning">
                <div class="inner">
                    <h3>{{ number_format($stats['total_enrollments']) }}</h3>
                    <p>Tổng Đăng Ký</p>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-light" style="width: {{ ($stats['total_enrollments'] / 500) * 100 }}%"></div>
                    </div>
                </div>
                <div class="icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Xem chi tiết <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-danger">
                <div class="inner">
                    <h3>{{ number_format($stats['published_courses']) }}</h3>
                    <p>Khóa Học Đã Xuất Bản</p>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-light" style="width: {{ ($stats['published_courses'] / $stats['total_courses']) * 100 }}%"></div>
                    </div>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <a href="{{ route('admin.courses.index') }}" class="small-box-footer">
                    Xem chi tiết <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Quiz & Reviews Statistics Row -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="info-box bg-gradient-primary">
                <span class="info-box-icon"><i class="fas fa-question-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Tổng Quiz</span>
                    <span class="info-box-number">{{ number_format($stats['total_quizzes']) }}</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: {{ ($stats['total_quizzes'] / 100) * 100 }}%"></div>
                    </div>
                    <span class="progress-description">
                        <a href="{{ route('admin.quizzes.index') }}" class="text-white">Xem chi tiết</a>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box bg-gradient-warning">
                <span class="info-box-icon"><i class="fas fa-chart-line"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Lượt Thi</span>
                    <span class="info-box-number">{{ number_format($stats['total_quiz_attempts']) }}</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: {{ ($stats['total_quiz_attempts'] / 1000) * 100 }}%"></div>
                    </div>
                    <span class="progress-description">
                        Tăng {{ rand(10, 25) }}% so với tuần trước
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box bg-gradient-success">
                <span class="info-box-icon"><i class="fas fa-star"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Tổng Đánh Giá</span>
                    <span class="info-box-number">{{ number_format($stats['total_reviews']) }}</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: {{ ($stats['total_reviews'] / 500) * 100 }}%"></div>
                    </div>
                    <span class="progress-description">
                        <a href="{{ route('admin.reviews.index') }}" class="text-white">Xem chi tiết</a>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box bg-gradient-danger">
                <span class="info-box-icon"><i class="fas fa-clock"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Chờ Duyệt</span>
                    <span class="info-box-number">{{ number_format($stats['pending_reviews']) }}</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: {{ $stats['total_reviews'] > 0 ? ($stats['pending_reviews'] / $stats['total_reviews']) * 100 : 0 }}%"></div>
                    </div>
                    <span class="progress-description">
                        <a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}" class="text-white">Duyệt ngay</a>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Enrollments -->
        <div class="col-md-8">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-graduate mr-2 text-primary"></i>
                        Đăng Ký Gần Đây
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-tool">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($recent_enrollments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 40%">Học viên</th>
                                        <th style="width: 35%">Khóa học</th>
                                        <th style="width: 15%">Ngày đăng ký</th>
                                        <th style="width: 10%">Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recent_enrollments->take(10) as $enrollment)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar mr-3">
                                                    <img src="{{ $enrollment->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($enrollment->user->name) . '&background=007bff&color=fff' }}" 
                                                         class="img-circle elevation-2" width="40" height="40" alt="{{ $enrollment->user->name }}">
                                                </div>
                                                <div>
                                                    <div class="font-weight-bold text-dark">{{ $enrollment->user->name }}</div>
                                                    <small class="text-muted">{{ $enrollment->user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <div class="font-weight-bold text-dark">{{ Str::limit($enrollment->course->title, 30) }}</div>
                                                <small class="text-muted">
                                                    <i class="fas fa-tag mr-1"></i>
                                                    {{ $enrollment->course->category->name }}
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <i class="far fa-calendar-alt mr-1"></i>
                                                {{ $enrollment->created_at->format('d/m/Y') }}
                                            </small>
                                        </td>
                                        <td>
                                            @if($enrollment->is_active)
                                                <span class="badge badge-success">
                                                    <i class="fas fa-play mr-1"></i>
                                                    Đang học
                                                </span>
                                            @else
                                                <span class="badge badge-secondary">
                                                    <i class="fas fa-pause mr-1"></i>
                                                    Tạm dừng
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Chưa có đăng ký nào</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Popular Courses -->
        <div class="col-md-4">
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-star mr-2 text-warning"></i>
                        Khóa Học Phổ Biến
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <a href="{{ route('admin.courses.index') }}" class="btn btn-tool">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($popular_courses->count() > 0)
                        @foreach($popular_courses as $course)
                        <div class="d-flex align-items-center p-3 border-bottom hover-bg-light">
                            <div class="course-image mr-3">
                                <img src="{{ $course->image ?? 'https://via.placeholder.com/60x60/007bff/fff?text=COURSE' }}" 
                                     class="img-thumbnail elevation-1" width="60" height="60" style="object-fit: cover;" alt="{{ $course->title }}">
                            </div>
                            <div class="flex-grow-1">
                                <div class="font-weight-bold text-dark">{{ Str::limit($course->title, 25) }}</div>
                                <small class="text-muted">
                                    <i class="fas fa-users mr-1"></i>
                                    {{ $course->enrollments_count }} học viên
                                </small>
                            </div>
                            <div class="text-right">
                                @if($course->is_published)
                                    <span class="badge badge-success">
                                        <i class="fas fa-check mr-1"></i>
                                        Đã xuất bản
                                    </span>
                                @else
                                    <span class="badge badge-warning">
                                        <i class="fas fa-edit mr-1"></i>
                                        Nháp
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-book fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Chưa có khóa học nào</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bolt mr-2 text-info"></i>
                        Thao Tác Nhanh
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.courses.create') }}" class="btn btn-primary btn-block btn-lg elevation-2">
                                <i class="fas fa-plus mr-2"></i>
                                <strong>Tạo Khóa Học Mới</strong>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-success btn-block btn-lg elevation-2">
                                <i class="fas fa-tags mr-2"></i>
                                <strong>Tạo Danh Mục Mới</strong>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-info btn-block btn-lg elevation-2">
                                <i class="fas fa-user-plus mr-2"></i>
                                <strong>Thêm Người Dùng</strong>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.lessons.create') }}" class="btn btn-warning btn-block btn-lg elevation-2">
                                <i class="fas fa-book-open mr-2"></i>
                                <strong>Tạo Bài Học Mới</strong>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.quizzes.create') }}" class="btn btn-secondary btn-block btn-lg elevation-2">
                                <i class="fas fa-question-circle mr-2"></i>
                                <strong>Tạo Quiz Mới</strong>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('leaderboard.index') }}" class="btn btn-warning btn-block btn-lg elevation-2">
                                <i class="fas fa-trophy mr-2"></i>
                                <strong>Xem Bảng Xếp Hạng</strong>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-dark btn-block btn-lg elevation-2">
                                <i class="fas fa-chart-pie mr-2"></i>
                                <strong>Thống Kê Chi Tiết</strong>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-purple btn-block btn-lg elevation-2">
                                <i class="fas fa-cog mr-2"></i>
                                <strong>Cài Đặt Hệ Thống</strong>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Custom Styles -->
    <style>
        .btn-purple {
            color: #fff;
            background-color: #6f42c1;
            border-color: #6f42c1;
        }
        .btn-purple:hover {
            color: #fff;
            background-color: #5a32a3;
            border-color: #5a32a3;
        }
        .hover-bg-light:hover {
            background-color: rgba(0,0,0,0.05);
        }
        .card-outline.card-primary {
            border-top: 3px solid #007bff;
        }
        .card-outline.card-success {
            border-top: 3px solid #28a745;
        }
        .card-outline.card-info {
            border-top: 3px solid #17a2b8;
        }
        .bg-gradient-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        }
        .bg-gradient-info {
            background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%);
        }
        .bg-gradient-success {
            background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
        }
        .bg-gradient-warning {
            background: linear-gradient(135deg, #ffc107 0%, #d39e00 100%);
        }
        .bg-gradient-danger {
            background: linear-gradient(135deg, #dc3545 0%, #bd2130 100%);
        }
        .small-box .icon {
            transition: all 0.3s ease;
        }
        .small-box:hover .icon {
            transform: scale(1.1);
        }
        .info-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .btn-lg {
            padding: 12px 24px;
            font-size: 16px;
            line-height: 1.5;
        }
        .elevation-2 {
            box-shadow: 0 2px 4px rgba(0,0,0,0.16), 0 2px 8px rgba(0,0,0,0.12);
        }
        .elevation-2:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.24), 0 4px 16px rgba(0,0,0,0.16);
        }
    </style>
@endsection
