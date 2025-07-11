@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Học Tiếng Anh Hiệu Quả Cùng Chúng Tôi</h1>
                <p class="lead mb-4">Nền tảng học tiếng Anh trực tuyến hàng đầu với phương pháp giảng dạy hiện đại, giúp bạn thành thạo tiếng Anh một cách nhanh chóng và hiệu quả.</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('courses.index') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-play me-2"></i>Bắt Đầu Học
                    </a>
                    <a href="#features" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-info-circle me-2"></i>Tìm Hiểu Thêm
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="text-center">
                    <i class="fas fa-graduation-cap" style="font-size: 200px; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="display-5 fw-bold">Tại Sao Chọn Chúng Tôi?</h2>
                <p class="lead text-muted">Những ưu điểm vượt trội của nền tảng học tiếng Anh</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-center p-4">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-chalkboard-teacher fa-2x"></i>
                    </div>
                    <h4>Giảng Viên Chuyên Nghiệp</h4>
                    <p class="text-muted">Đội ngũ giảng viên giàu kinh nghiệm, được đào tạo bài bản và có chứng chỉ quốc tế.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center p-4">
                    <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                    <h4>Học Mọi Lúc Mọi Nơi</h4>
                    <p class="text-muted">Linh hoạt thời gian học tập, có thể học bất cứ khi nào và ở đâu bạn muốn.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center p-4">
                    <div class="bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-certificate fa-2x"></i>
                    </div>
                    <h4>Chứng Chỉ Uy Tín</h4>
                    <p class="text-muted">Nhận chứng chỉ hoàn thành khóa học được công nhận rộng rãi trong ngành.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Courses Section -->
@if($featured_courses->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="display-5 fw-bold">Khóa Học Nổi Bật</h2>
                <p class="lead text-muted">Những khóa học được yêu thích nhất</p>
            </div>
        </div>
        <div class="row g-4">
            @foreach($featured_courses as $course)
            <div class="col-lg-4 col-md-6">
                <div class="card course-card h-100">
                    @if($course->image)
                        <img src="{{ $course->image }}" class="card-img-top" alt="{{ $course->title }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-primary text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-book fa-3x"></i>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-primary">{{ $course->category->name }}</span>
                            <span class="badge bg-secondary">{{ ucfirst($course->level) }}</span>
                        </div>
                        <h5 class="card-title">{{ $course->title }}</h5>
                        <p class="card-text text-muted flex-grow-1">{{ Str::limit($course->short_description, 100) }}</p>
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <small class="text-muted">
                                    <i class="fas fa-user me-1"></i>{{ $course->instructor->name }}
                                </small>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>{{ $course->duration_hours }}h
                                </small>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 text-primary mb-0">
                                    @if($course->price > 0)
                                        {{ number_format($course->price, 0, ',', '.') }}đ
                                    @else
                                        Miễn phí
                                    @endif
                                </span>
                                <a href="{{ route('courses.show', $course->slug) }}" class="btn btn-primary">
                                    Xem Chi Tiết
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('courses.index') }}" class="btn btn-outline-primary btn-lg">
                Xem Tất Cả Khóa Học <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>
@endif

<!-- Categories Section -->
@if($categories->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="display-5 fw-bold">Danh Mục Khóa Học</h2>
                <p class="lead text-muted">Chọn lĩnh vực bạn muốn học</p>
            </div>
        </div>
        <div class="row g-4">
            @foreach($categories as $category)
            <div class="col-lg-4 col-md-6">
                <div class="category-card h-100">
                    <div class="mb-3">
                        <i class="fas fa-book-open fa-3x text-primary"></i>
                    </div>
                    <h4>{{ $category->name }}</h4>
                    <p class="text-muted mb-3">{{ $category->description }}</p>
                    <p class="fw-bold text-primary">{{ $category->courses_count }} khóa học</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Stats Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-3">
                <div class="mb-2">
                    <i class="fas fa-users fa-3x"></i>
                </div>
                <h3 class="fw-bold">10,000+</h3>
                <p>Học Viên</p>
            </div>
            <div class="col-md-3">
                <div class="mb-2">
                    <i class="fas fa-book fa-3x"></i>
                </div>
                <h3 class="fw-bold">100+</h3>
                <p>Khóa Học</p>
            </div>
            <div class="col-md-3">
                <div class="mb-2">
                    <i class="fas fa-chalkboard-teacher fa-3x"></i>
                </div>
                <h3 class="fw-bold">50+</h3>
                <p>Giảng Viên</p>
            </div>
            <div class="col-md-3">
                <div class="mb-2">
                    <i class="fas fa-star fa-3x"></i>
                </div>
                <h3 class="fw-bold">4.8/5</h3>
                <p>Đánh Giá</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="display-5 fw-bold mb-4">Sẵn Sàng Bắt Đầu Hành Trình Học Tiếng Anh?</h2>
                <p class="lead text-muted mb-4">Tham gia cùng hàng nghìn học viên đã thành công với chúng tôi</p>
                @guest
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-3">
                        <i class="fas fa-user-plus me-2"></i>Đăng Ký Ngay
                    </a>
                    <a href="{{ route('courses.index') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-search me-2"></i>Khám Phá Khóa Học
                    </a>
                @else
                    <a href="{{ route('courses.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-play me-2"></i>Bắt Đầu Học Ngay
                    </a>
                @endguest
            </div>
        </div>
    </div>
</section>
@endsection
