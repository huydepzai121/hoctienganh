@extends('layouts.adminlte-pure')

@section('title', 'Dashboard - Admin')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Dashboard</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <!-- Stats Cards -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ number_format($stats['total_users']) }}</h3>
                    <p>Tổng Người Dùng</p>
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
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ number_format($stats['total_courses']) }}</h3>
                    <p>Tổng Khóa Học</p>
                </div>
                <div class="icon">
                    <i class="fas fa-book"></i>
                </div>
                <a href="{{ route('admin.courses.index') }}" class="small-box-footer">
                    Xem chi tiết <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ number_format($stats['total_enrollments']) }}</h3>
                    <p>Tổng Đăng Ký</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Xem chi tiết <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ number_format($stats['published_courses']) }}</h3>
                    <p>Khóa Học Đã Xuất Bản</p>
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

    <div class="row">
        <!-- Recent Enrollments -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-graduate mr-1"></i>
                        Đăng Ký Gần Đây
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-tool">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($recent_enrollments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Học viên</th>
                                        <th>Khóa học</th>
                                        <th>Ngày đăng ký</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recent_enrollments->take(10) as $enrollment)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $enrollment->user->avatar ?? 'https://via.placeholder.com/32x32/007bff/ffffff?text=' . substr($enrollment->user->name, 0, 1) }}" 
                                                     class="img-circle mr-2" width="32" height="32" alt="{{ $enrollment->user->name }}">
                                                <div>
                                                    <div class="font-weight-bold">{{ $enrollment->user->name }}</div>
                                                    <small class="text-muted">{{ $enrollment->user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <div class="font-weight-bold">{{ Str::limit($enrollment->course->title, 30) }}</div>
                                                <small class="text-muted">{{ $enrollment->course->category->name }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <small>{{ $enrollment->enrolled_at->format('d/m/Y H:i') }}</small>
                                        </td>
                                        <td>
                                            @if($enrollment->is_active)
                                                <span class="badge badge-success">Đang học</span>
                                            @else
                                                <span class="badge badge-secondary">Tạm dừng</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Chưa có đăng ký nào</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Popular Courses -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-star mr-1"></i>
                        Khóa Học Phổ Biến
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.courses.index') }}" class="btn btn-tool">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($popular_courses->count() > 0)
                        @foreach($popular_courses as $course)
                        <div class="d-flex align-items-center p-3 border-bottom">
                            <img src="{{ $course->image ?? 'https://via.placeholder.com/50x50/007bff/ffffff?text=C' }}" 
                                 class="img-thumbnail mr-3" width="50" height="50" style="object-fit: cover;" alt="{{ $course->title }}">
                            <div class="flex-grow-1">
                                <div class="font-weight-bold">{{ Str::limit($course->title, 25) }}</div>
                                <small class="text-muted">{{ $course->enrollments_count }} học viên</small>
                            </div>
                            <div class="text-right">
                                @if($course->is_published)
                                    <span class="badge badge-success">Đã xuất bản</span>
                                @else
                                    <span class="badge badge-warning">Nháp</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
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
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bolt mr-1"></i>
                        Thao Tác Nhanh
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.courses.create') }}" class="btn btn-primary btn-block">
                                <i class="fas fa-plus mr-2"></i>Tạo Khóa Học Mới
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-success btn-block">
                                <i class="fas fa-tags mr-2"></i>Tạo Danh Mục Mới
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-info btn-block">
                                <i class="fas fa-user-plus mr-2"></i>Thêm Người Dùng
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.lessons.create') }}" class="btn btn-warning btn-block">
                                <i class="fas fa-book-open mr-2"></i>Tạo Bài Học Mới
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
