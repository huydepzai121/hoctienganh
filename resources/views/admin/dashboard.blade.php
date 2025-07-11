@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-download me-1"></i>Xuất báo cáo
            </button>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Tổng Người Dùng</div>
                        <div class="h5 mb-0 font-weight-bold">{{ number_format($stats['total_users']) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card-success">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Tổng Khóa Học</div>
                        <div class="h5 mb-0 font-weight-bold">{{ number_format($stats['total_courses']) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card-warning">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Tổng Đăng Ký</div>
                        <div class="h5 mb-0 font-weight-bold">{{ number_format($stats['total_enrollments']) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-graduate fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card-info">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Khóa Học Đã Xuất Bản</div>
                        <div class="h5 mb-0 font-weight-bold">{{ number_format($stats['published_courses']) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Enrollments -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Đăng Ký Gần Đây</h5>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary">Xem tất cả</a>
            </div>
            <div class="card-body p-0">
                @if($recent_enrollments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Học viên</th>
                                    <th>Khóa học</th>
                                    <th>Ngày đăng ký</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_enrollments as $enrollment)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($enrollment->user->avatar)
                                                <img src="{{ $enrollment->user->avatar }}" class="rounded-circle me-2" width="32" height="32" alt="{{ $enrollment->user->name }}">
                                            @else
                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                                    <i class="fas fa-user fa-sm"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold">{{ $enrollment->user->name }}</div>
                                                <small class="text-muted">{{ $enrollment->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <div class="fw-bold">{{ Str::limit($enrollment->course->title, 30) }}</div>
                                            <small class="text-muted">{{ $enrollment->course->category->name }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <small>{{ $enrollment->enrolled_at->format('d/m/Y H:i') }}</small>
                                    </td>
                                    <td>
                                        @if($enrollment->is_active)
                                            <span class="badge bg-success">Đang học</span>
                                        @else
                                            <span class="badge bg-secondary">Tạm dừng</span>
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
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Khóa Học Phổ Biến</h5>
                <a href="{{ route('admin.courses.index') }}" class="btn btn-sm btn-outline-primary">Xem tất cả</a>
            </div>
            <div class="card-body p-0">
                @if($popular_courses->count() > 0)
                    @foreach($popular_courses as $course)
                    <div class="d-flex align-items-center p-3 border-bottom">
                        @if($course->image)
                            <img src="{{ $course->image }}" class="rounded me-3" width="50" height="50" style="object-fit: cover;" alt="{{ $course->title }}">
                        @else
                            <div class="bg-primary text-white rounded d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <i class="fas fa-book"></i>
                            </div>
                        @endif
                        <div class="flex-grow-1">
                            <div class="fw-bold">{{ Str::limit($course->title, 25) }}</div>
                            <small class="text-muted">{{ $course->enrollments_count }} học viên</small>
                        </div>
                        <div class="text-end">
                            @if($course->is_published)
                                <span class="badge bg-success">Đã xuất bản</span>
                            @else
                                <span class="badge bg-warning">Nháp</span>
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
                <h5 class="mb-0">Thao Tác Nhanh</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <a href="{{ route('admin.courses.create') }}" class="btn btn-primary w-100">
                            <i class="fas fa-plus me-2"></i>Tạo Khóa Học Mới
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-success w-100">
                            <i class="fas fa-tags me-2"></i>Tạo Danh Mục Mới
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-info w-100">
                            <i class="fas fa-user-plus me-2"></i>Thêm Người Dùng
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.lessons.create') }}" class="btn btn-warning w-100">
                            <i class="fas fa-book-open me-2"></i>Tạo Bài Học Mới
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
