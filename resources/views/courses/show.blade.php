@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Course Header -->
    <div class="row mb-5">
        <div class="col-lg-8">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Khóa học</a></li>
                    <li class="breadcrumb-item active">{{ $course->title }}</li>
                </ol>
            </nav>
            
            <div class="mb-3">
                <span class="badge bg-primary me-2">{{ $course->category->name }}</span>
                <span class="badge bg-secondary me-2">{{ ucfirst($course->level) }}</span>
                @if($course->is_featured)
                    <span class="badge bg-warning">Nổi bật</span>
                @endif
            </div>
            
            <h1 class="display-5 fw-bold mb-3">{{ $course->title }}</h1>
            <p class="lead text-muted mb-4">{{ $course->short_description }}</p>
            
            <div class="row g-3 mb-4">
                <div class="col-auto">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user text-primary me-2"></i>
                        <span>{{ $course->instructor->name }}</span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-clock text-primary me-2"></i>
                        <span>{{ $course->duration_hours }} giờ</span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-book-open text-primary me-2"></i>
                        <span>{{ $course->lessons->count() }} bài học</span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-users text-primary me-2"></i>
                        <span>{{ $course->student_count }} học viên</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-body text-center">
                    @if($course->image)
                        <img src="{{ $course->image }}" class="img-fluid rounded mb-3" alt="{{ $course->title }}">
                    @else
                        <div class="bg-primary text-white d-flex align-items-center justify-content-center rounded mb-3" style="height: 200px;">
                            <i class="fas fa-book fa-4x"></i>
                        </div>
                    @endif
                    
                    <div class="mb-3">
                        <span class="h3 text-primary">
                            @if($course->price > 0)
                                {{ number_format($course->price, 0, ',', '.') }}đ
                            @else
                                Miễn phí
                            @endif
                        </span>
                    </div>
                    
                    @auth
                        @if($isEnrolled)
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>
                                Bạn đã đăng ký khóa học này
                            </div>
                            @if($course->lessons->count() > 0)
                                <a href="{{ route('lessons.show', $course->lessons->first()->slug) }}" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-play me-2"></i>Tiếp tục học
                                </a>
                            @endif
                        @else
                            <form method="POST" action="{{ route('courses.enroll', $course) }}">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-plus me-2"></i>Đăng ký khóa học
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập để học
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
    
    <!-- Course Content -->
    <div class="row">
        <div class="col-lg-8">
            <!-- Course Description -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="mb-0">Mô tả khóa học</h4>
                </div>
                <div class="card-body">
                    <div class="course-description">
                        {!! nl2br(e($course->description)) !!}
                    </div>
                </div>
            </div>
            
            <!-- Course Curriculum -->
            @if($course->lessons->count() > 0)
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="mb-0">Nội dung khóa học</h4>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($course->lessons as $index => $lesson)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-primary me-3">{{ $index + 1 }}</span>
                                    <div>
                                        <h6 class="mb-1">{{ $lesson->title }}</h6>
                                        @if($lesson->summary)
                                            <small class="text-muted">{{ $lesson->summary }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    @if($lesson->duration_minutes)
                                        <small class="text-muted me-3">
                                            <i class="fas fa-clock me-1"></i>{{ $lesson->duration_minutes }} phút
                                        </small>
                                    @endif
                                    @if($lesson->is_free)
                                        <span class="badge bg-success">Miễn phí</span>
                                    @elseif(!$isEnrolled)
                                        <i class="fas fa-lock text-muted"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Instructor Info -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="mb-0">Giảng viên</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        @if($course->instructor->avatar)
                            <img src="{{ $course->instructor->avatar }}" class="rounded-circle me-3" width="60" height="60" alt="{{ $course->instructor->name }}">
                        @else
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif
                        <div>
                            <h5 class="mb-1">{{ $course->instructor->name }}</h5>
                            @if($course->instructor->bio)
                                <p class="text-muted mb-0">{{ $course->instructor->bio }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Reviews -->
            <x-course-reviews :course="$course" />
        </div>
        
        <div class="col-lg-4">
            <!-- Related Courses -->
            @if($relatedCourses->count() > 0)
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Khóa học liên quan</h5>
                </div>
                <div class="card-body p-0">
                    @foreach($relatedCourses as $relatedCourse)
                    <div class="p-3 border-bottom">
                        <div class="d-flex">
                            @if($relatedCourse->image)
                                <img src="{{ $relatedCourse->image }}" class="rounded me-3" width="60" height="60" style="object-fit: cover;" alt="{{ $relatedCourse->title }}">
                            @else
                                <div class="bg-primary text-white rounded d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                    <i class="fas fa-book"></i>
                                </div>
                            @endif
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    <a href="{{ route('courses.show', $relatedCourse->slug) }}" class="text-decoration-none">
                                        {{ Str::limit($relatedCourse->title, 50) }}
                                    </a>
                                </h6>
                                <small class="text-muted">{{ $relatedCourse->instructor->name }}</small>
                                <div class="mt-1">
                                    <span class="text-primary fw-bold">
                                        @if($relatedCourse->price > 0)
                                            {{ number_format($relatedCourse->price, 0, ',', '.') }}đ
                                        @else
                                            Miễn phí
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@if(session('success'))
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div class="toast show" role="alert">
            <div class="toast-header">
                <i class="fas fa-check-circle text-success me-2"></i>
                <strong class="me-auto">Thành công</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                {{ session('success') }}
            </div>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div class="toast show" role="alert">
            <div class="toast-header">
                <i class="fas fa-exclamation-circle text-danger me-2"></i>
                <strong class="me-auto">Lỗi</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                {{ session('error') }}
            </div>
        </div>
    </div>
@endif
@endsection
