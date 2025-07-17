@extends('layouts.app')

@section('content')
<!-- Hero Section - Gradient Background như React -->
<section class="position-relative overflow-hidden" style="background: linear-gradient(135deg, #3B82F6 0%, #8B5CF6 50%, #4F46E5 100%); min-height: 100vh;">
    <!-- Background Pattern -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0,0,0,0.1);"></div>
    <div class="position-absolute top-0 start-0 w-100 h-100 opacity-20" style="background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIj48Y2lyY2xlIGN4PSIzMCIgY3k9IjMwIiByPSIyIi8+PC9nPjwvZz48L3N2Zz4=');"></div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center min-vh-100 py-5">
            <!-- Left Content -->
            <div class="col-lg-7">
                <div class="pe-lg-5">
                    <!-- Badge -->
                    <div class="mb-4">
                        <span class="badge bg-white bg-opacity-10 text-white px-4 py-2 rounded-pill fs-6 backdrop-blur">
                            <i class="fas fa-graduation-cap me-2"></i>Nền tảng học tiếng Anh #1 Việt Nam
                        </span>
                    </div>

                    <!-- Main Heading -->
                    <h1 class="display-3 fw-bold text-white mb-4 lh-1">
                        Học Tiếng Anh Hiệu Quả
                        <span class="d-block" style="background: linear-gradient(135deg, #FCD34D, #F97316); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                            Cùng Chúng Tôi
                        </span>
                    </h1>

                    <!-- Description -->
                    <p class="fs-5 text-white-50 mb-5 pe-lg-3" style="line-height: 1.6;">
                        Nền tảng học tiếng Anh trực tuyến hàng đầu với phương pháp giảng dạy hiện đại,
                        giúp bạn thành thạo tiếng Anh một cách nhanh chóng và hiệu quả.
                    </p>

                    <!-- CTA Buttons -->
                    <div class="d-flex flex-column flex-sm-row gap-3 mb-5">
                        <a href="{{ route('courses.index') }}" class="btn btn-light btn-lg px-4 py-3 rounded-3 fw-semibold">
                            <i class="fas fa-play me-2"></i>Bắt Đầu Học
                        </a>
                        <a href="#features" class="btn btn-outline-light btn-lg px-4 py-3 rounded-3 fw-semibold">
                            Tìm Hiểu Thêm
                            <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>

                    <!-- Stats -->
                    <div class="row g-4 pt-4">
                        <div class="col-4">
                            <div class="text-center text-lg-start">
                                <div class="h2 fw-bold text-white mb-1">50K+</div>
                                <div class="text-white-50 small">Học viên</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="text-center text-lg-start">
                                <div class="h2 fw-bold text-white mb-1">200+</div>
                                <div class="text-white-50 small">Khóa học</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="text-center text-lg-start">
                                <div class="h2 fw-bold text-white mb-1">98%</div>
                                <div class="text-white-50 small">Hài lòng</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Hero Images -->
            <div class="col-lg-5">
                <div class="text-center position-relative">
                    <!-- Main Hero Image -->
                    <div class="position-relative d-inline-block">
                        <div class="bg-white bg-opacity-10 rounded-4 p-5 backdrop-blur border border-white border-opacity-20">
                            <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                                 style="width: 120px; height: 120px;">
                                <i class="fas fa-play text-white" style="font-size: 40px; margin-left: 8px;"></i>
                            </div>
                            <h5 class="text-white mb-3">Xem Video Giới Thiệu</h5>
                            <p class="text-white-50 mb-0">Khám phá phương pháp học hiệu quả</p>
                        </div>

                        <!-- Floating Elements -->
                        <div class="position-absolute top-0 start-0 translate-middle">
                            <div class="bg-warning rounded-circle p-3 shadow">
                                <i class="fas fa-star text-white"></i>
                            </div>
                        </div>
                        <div class="position-absolute bottom-0 end-0 translate-middle-x">
                            <div class="bg-success rounded-circle p-3 shadow">
                                <i class="fas fa-check text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section id="features" class="py-5" style="background-color: #f8fafc;">
    <div class="container py-5">
        <!-- Section Header -->
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <h2 class="display-5 fw-bold text-dark mb-4">Tại Sao Chọn Chúng Tôi?</h2>
                <p class="fs-5 text-muted">Những ưu điểm vượt trội của nền tảng học tiếng Anh hàng đầu</p>
            </div>
        </div>

        <!-- Feature Cards -->
        <div class="row g-4">
            <!-- Card 1: Giảng Viên Chuyên Nghiệp -->
            <div class="col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-4 text-center">
                        <!-- Icon với gradient background -->
                        <div class="mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-4 p-3"
                                 style="background: linear-gradient(135deg, #3B82F6 0%, #06B6D4 100%); width: 80px; height: 80px;">
                                <i class="fas fa-chalkboard-teacher text-white" style="font-size: 32px;"></i>
                            </div>
                        </div>

                        <h4 class="fw-bold text-dark mb-3">Giảng Viên Chuyên Nghiệp</h4>
                        <p class="text-muted mb-0">
                            Đội ngũ giảng viên giàu kinh nghiệm với chứng chỉ quốc tế,
                            cam kết mang lại chất lượng giảng dạy tốt nhất.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Card 2: Học Mọi Lúc Mọi Nơi -->
            <div class="col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-4 text-center">
                        <!-- Icon với gradient background -->
                        <div class="mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-4 p-3"
                                 style="background: linear-gradient(135deg, #A855F7 0%, #EC4899 100%); width: 80px; height: 80px;">
                                <i class="fas fa-mobile-alt text-white" style="font-size: 32px;"></i>
                            </div>
                        </div>

                        <h4 class="fw-bold text-dark mb-3">Học Mọi Lúc Mọi Nơi</h4>
                        <p class="text-muted mb-0">
                            Linh hoạt thời gian học với nền tảng trực tuyến, bạn có thể
                            học bất cứ khi nào và ở đâu bạn muốn.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Card 3: Chứng Chỉ Uy Tín -->
            <div class="col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-4 text-center">
                        <!-- Icon với gradient background -->
                        <div class="mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-4 p-3"
                                 style="background: linear-gradient(135deg, #F97316 0%, #F43F5E 100%); width: 80px; height: 80px;">
                                <i class="fas fa-certificate text-white" style="font-size: 32px;"></i>
                            </div>
                        </div>

                        <h4 class="fw-bold text-dark mb-3">Chứng Chỉ Uy Tín</h4>
                        <p class="text-muted mb-0">
                            Nhận chứng chỉ được công nhận quốc tế sau khi hoàn thành
                            khóa học, nâng cao cơ hội nghề nghiệp.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Courses Section -->
<section class="py-5">
    <div class="container py-5">
        <!-- Section Header -->
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <h2 class="display-5 fw-bold text-dark mb-4">Khóa Học Nổi Bật</h2>
                <p class="fs-5 text-muted">Những khóa học được yêu thích nhất với chất lượng giảng dạy xuất sắc</p>
            </div>
        </div>

        <!-- Course Cards - Dữ liệu thực tế -->
        <div class="row g-4">
            @if($featured_courses && $featured_courses->count() > 0)
                @foreach($featured_courses->take(4) as $course)
                    <div class="col-lg-3">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden course-card">
                            <div class="position-relative">
                                @if($course->image)
                                    <img src="{{ asset('storage/' . $course->image) }}"
                                         class="card-img-top" alt="{{ $course->title }}"
                                         style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="d-flex align-items-center justify-content-center"
                                         style="height: 200px; background: linear-gradient(135deg, {{ $course->category->color ?? '#3B82F6' }} 0%, {{ $course->category->color ?? '#8B5CF6' }} 100%);">
                                        <i class="fas {{ $course->category->icon ?? 'fa-book' }} text-white" style="font-size: 48px;"></i>
                                    </div>
                                @endif

                                <!-- Level Badge -->
                                @if($course->level)
                                    <span class="position-absolute top-0 start-0 m-3 badge rounded-pill
                                        @if($course->level == 'beginner') bg-success
                                        @elseif($course->level == 'intermediate') bg-warning
                                        @elseif($course->level == 'advanced') bg-danger
                                        @else bg-primary @endif">
                                        @if($course->level == 'beginner') Cơ bản
                                        @elseif($course->level == 'intermediate') Trung cấp
                                        @elseif($course->level == 'advanced') Nâng cao
                                        @else {{ ucfirst($course->level) }} @endif
                                    </span>
                                @endif

                                <!-- Featured Badge -->
                                @if($course->is_featured)
                                    <span class="position-absolute top-0 end-0 m-3 badge bg-warning rounded-pill">
                                        <i class="fas fa-star me-1"></i>Nổi bật
                                    </span>
                                @endif
                            </div>

                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-3">{{ $course->title }}</h5>
                                <p class="text-muted mb-3 small">{{ Str::limit($course->description, 80) }}</p>

                                <!-- Instructor -->
                                @if($course->instructor)
                                    <div class="mb-3">
                                        <small class="text-muted">
                                            <i class="fas fa-user-tie me-1"></i>{{ $course->instructor->name }}
                                        </small>
                                    </div>
                                @endif

                                <!-- Rating & Stats -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="text-warning me-2">
                                            <i class="fas fa-star"></i>
                                            <span class="small fw-bold">{{ number_format($course->average_rating ?? 4.5, 1) }}</span>
                                        </div>
                                        <small class="text-muted">({{ $course->enrollments_count ?? 0 }})</small>
                                    </div>
                                    <small class="text-muted">
                                        <i class="fas fa-book me-1"></i>{{ $course->lessons_count ?? 0 }} bài
                                    </small>
                                </div>

                                <!-- Price & Duration -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        @if($course->price > 0)
                                            <span class="fw-bold text-primary fs-5">{{ number_format($course->price) }}đ</span>
                                            @if($course->original_price && $course->original_price > $course->price)
                                                <small class="text-muted text-decoration-line-through ms-2">{{ number_format($course->original_price) }}đ</small>
                                            @endif
                                        @else
                                            <span class="fw-bold text-success fs-5">Miễn phí</span>
                                        @endif
                                    </div>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>{{ $course->duration ?? '8' }} tuần
                                    </small>
                                </div>

                                <a href="{{ route('courses.show', $course) }}" class="btn btn-primary w-100 rounded-3">
                                    Xem Chi Tiết
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Fallback static courses nếu chưa có dữ liệu -->
                <div class="col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="position-relative">
                            <div class="bg-primary d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-comments text-white" style="font-size: 48px;"></i>
                            </div>
                            <span class="position-absolute top-0 start-0 m-3 badge bg-success rounded-pill">Cơ bản</span>
                        </div>

                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">Tiếng Anh Giao Tiếp Cơ Bản</h5>
                            <p class="text-muted mb-3 small">Học tiếng Anh giao tiếp cơ bản đến thành thạo theo phương pháp hiện đại và hiệu quả.</p>

                            <div class="mb-3">
                                <small class="text-muted"><i class="fas fa-user-tie me-1"></i>Thầy Vinh Giang</small>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="text-warning me-2">
                                        <i class="fas fa-star"></i>
                                        <span class="small fw-bold">4.9</span>
                                    </div>
                                    <small class="text-muted">(2,847)</small>
                                </div>
                                <small class="text-muted">
                                    <i class="fas fa-book me-1"></i>24 bài
                                </small>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="fw-bold text-success fs-5">Miễn phí</div>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>8 tuần
                                </small>
                            </div>

                            <a href="{{ route('courses.index') }}" class="btn btn-primary w-100 rounded-3">Xem Chi Tiết</a>
                        </div>
                    </div>
                </div>

                <!-- Thêm 3 course mẫu khác tương tự... -->
                <div class="col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="position-relative">
                            <div class="bg-warning d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-microphone text-white" style="font-size: 48px;"></i>
                            </div>
                            <span class="position-absolute top-0 start-0 m-3 badge bg-danger rounded-pill">Nâng cao</span>
                            <span class="position-absolute top-0 end-0 m-3 badge bg-warning rounded-pill"><i class="fas fa-star me-1"></i>Nổi bật</span>
                        </div>

                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">IELTS Speaking Band 7+</h5>
                            <p class="text-muted mb-3 small">Chinh phục IELTS Speaking với band điểm cao thông qua phương pháp luyện tập chuyên sâu.</p>

                            <div class="mb-3">
                                <small class="text-muted"><i class="fas fa-user-tie me-1"></i>Cô Linh Phạm</small>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="text-warning me-2">
                                        <i class="fas fa-star"></i>
                                        <span class="small fw-bold">4.8</span>
                                    </div>
                                    <small class="text-muted">(1,952)</small>
                                </div>
                                <small class="text-muted">
                                    <i class="fas fa-book me-1"></i>32 bài
                                </small>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <span class="fw-bold text-primary fs-5">1.500.000đ</span>
                                    <small class="text-muted text-decoration-line-through ms-2">2.000.000đ</small>
                                </div>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>12 tuần
                                </small>
                            </div>

                            <a href="{{ route('courses.index') }}" class="btn btn-primary w-100 rounded-3">Xem Chi Tiết</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="position-relative">
                            <div class="bg-info d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-book-open text-white" style="font-size: 48px;"></i>
                            </div>
                            <span class="position-absolute top-0 start-0 m-3 badge bg-warning rounded-pill">Trung cấp</span>
                        </div>

                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">Ngữ Pháp Tiếng Anh A-Z</h5>
                            <p class="text-muted mb-3 small">Nắm vững ngữ pháp tiếng Anh một cách thể hệ từ cơ bản đến nâng cao.</p>

                            <div class="mb-3">
                                <small class="text-muted"><i class="fas fa-user-tie me-1"></i>Thầy Nam Phạm</small>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="text-warning me-2">
                                        <i class="fas fa-star"></i>
                                        <span class="small fw-bold">4.9</span>
                                    </div>
                                    <small class="text-muted">(3,241)</small>
                                </div>
                                <small class="text-muted">
                                    <i class="fas fa-book me-1"></i>48 bài
                                </small>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <span class="fw-bold text-primary fs-5">800.000đ</span>
                                    <small class="text-muted text-decoration-line-through ms-2">1.200.000đ</small>
                                </div>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>16 tuần
                                </small>
                            </div>

                            <a href="{{ route('courses.index') }}" class="btn btn-primary w-100 rounded-3">Xem Chi Tiết</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="position-relative">
                            <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-spell-check text-white" style="font-size: 48px;"></i>
                            </div>
                            <span class="position-absolute top-0 start-0 m-3 badge bg-success rounded-pill">Cơ bản</span>
                        </div>

                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">3000 Từ Vựng Thiết Yếu</h5>
                            <p class="text-muted mb-3 small">Mở rộng vốn từ vựng tiếng Anh theo chủ đề với phương pháp ghi nhớ hiệu quả.</p>

                            <div class="mb-3">
                                <small class="text-muted"><i class="fas fa-user-tie me-1"></i>Cô Mai Dương</small>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="text-warning me-2">
                                        <i class="fas fa-star"></i>
                                        <span class="small fw-bold">4.7</span>
                                    </div>
                                    <small class="text-muted">(1,864)</small>
                                </div>
                                <small class="text-muted">
                                    <i class="fas fa-book me-1"></i>30 bài
                                </small>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <span class="fw-bold text-primary fs-5">600.000đ</span>
                                    <small class="text-muted text-decoration-line-through ms-2">900.000đ</small>
                                </div>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>10 tuần
                                </small>
                            </div>

                            <a href="{{ route('courses.index') }}" class="btn btn-primary w-100 rounded-3">Xem Chi Tiết</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('courses.index') }}" class="btn btn-outline-primary btn-lg px-5 py-3 rounded-3">
                Xem Tất Cả Khóa Học
            </a>
        </div>
    </div>
</section>

<!-- Course Categories Section -->
<section class="py-5" style="background-color: #f8fafc;">
    <div class="container py-5">
        <!-- Section Header -->
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <h2 class="display-5 fw-bold text-dark mb-4">Danh Mục Khóa Học</h2>
                <p class="fs-5 text-muted">Chọn lĩnh vực bạn muốn học và phát triển kỹ năng tiếng Anh của mình</p>
            </div>
        </div>

        <!-- Category Cards - Dữ liệu thực tế -->
        <div class="row g-4">
            @if($categories && $categories->count() > 0)
                @foreach($categories as $category)
                    <div class="col-lg-4">
                        <a href="{{ route('courses.index', ['category' => $category->slug ?? $category->id]) }}" class="text-decoration-none">
                            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden category-card">
                                <div class="card-body p-4">
                                    <div class="text-center mb-4">
                                        <div class="d-inline-flex align-items-center justify-content-center rounded-4 p-3 mb-3"
                                             style="background: linear-gradient(135deg, {{ $category->color ?? '#3B82F6' }} 0%, {{ $category->secondary_color ?? '#8B5CF6' }} 100%); width: 80px; height: 80px;">
                                            <i class="fas {{ $category->icon ?? 'fa-book' }} text-white" style="font-size: 32px;"></i>
                                        </div>
                                    </div>

                                    <h4 class="fw-bold text-dark mb-3 text-center">{{ $category->name }}</h4>
                                    <p class="text-muted mb-4 text-center">
                                        {{ $category->description ?? 'Khám phá các khóa học chất lượng trong danh mục này.' }}
                                    </p>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted">{{ $category->courses_count }} khóa học</span>
                                        <i class="fas fa-arrow-right text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            @else
                <!-- Fallback static categories nếu chưa có dữ liệu -->
                <div class="col-lg-4">
                    <a href="{{ route('courses.index') }}" class="text-decoration-none">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden category-card">
                            <div class="card-body p-4">
                                <div class="text-center mb-4">
                                    <div class="d-inline-flex align-items-center justify-content-center rounded-4 p-3 mb-3"
                                         style="background: linear-gradient(135deg, #3B82F6 0%, #06B6D4 100%); width: 80px; height: 80px;">
                                        <i class="fas fa-comments text-white" style="font-size: 32px;"></i>
                                    </div>
                                </div>

                                <h4 class="fw-bold text-dark mb-3 text-center">Tiếng Anh Giao Tiếp</h4>
                                <p class="text-muted mb-4 text-center">
                                    Học tiếng Anh giao tiếp hàng ngày, gây dựng sự tự tin trong giao tiếp với người nước ngoài.
                                </p>

                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">12 khóa học</span>
                                    <i class="fas fa-arrow-right text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-4">
                    <a href="{{ route('courses.index') }}" class="text-decoration-none">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden category-card">
                            <div class="card-body p-4">
                                <div class="text-center mb-4">
                                    <div class="d-inline-flex align-items-center justify-content-center rounded-4 p-3 mb-3"
                                         style="background: linear-gradient(135deg, #A855F7 0%, #EC4899 100%); width: 80px; height: 80px;">
                                        <i class="fas fa-briefcase text-white" style="font-size: 32px;"></i>
                                    </div>
                                </div>

                                <h4 class="fw-bold text-dark mb-3 text-center">Tiếng Anh Thương Mại</h4>
                                <p class="text-muted mb-4 text-center">
                                    Tiếng Anh chuyên ngành kinh doanh và thương mại, nâng cao khả năng làm việc chuyên nghiệp.
                                </p>

                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">8 khóa học</span>
                                    <i class="fas fa-arrow-right text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-4">
                    <a href="{{ route('courses.index') }}" class="text-decoration-none">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden category-card">
                            <div class="card-body p-4">
                                <div class="text-center mb-4">
                                    <div class="d-inline-flex align-items-center justify-content-center rounded-4 p-3 mb-3"
                                         style="background: linear-gradient(135deg, #F97316 0%, #F43F5E 100%); width: 80px; height: 80px;">
                                        <i class="fas fa-award text-white" style="font-size: 32px;"></i>
                                    </div>
                                </div>

                                <h4 class="fw-bold text-dark mb-3 text-center">IELTS</h4>
                                <p class="text-muted mb-4 text-center">
                                    Luyện thi IELTS - International English Language Testing System với đội ngũ giảng viên chuyên nghiệp.
                                </p>

                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">15 khóa học</span>
                                    <i class="fas fa-arrow-right text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden category-card">
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <div class="d-inline-flex align-items-center justify-content-center rounded-4 p-3 mb-3"
                                     style="background: linear-gradient(135deg, #10B981 0%, #059669 100%); width: 80px; height: 80px;">
                                    <i class="fas fa-certificate text-white" style="font-size: 32px;"></i>
                                </div>
                            </div>

                            <h4 class="fw-bold text-dark mb-3 text-center">TOEIC</h4>
                            <p class="text-muted mb-4 text-center">
                                Luyện thi TOEIC - Test of English for International Communication với phương pháp hiệu quả.
                            </p>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">10 khóa học</span>
                                <i class="fas fa-arrow-right text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden category-card">
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <div class="d-inline-flex align-items-center justify-content-center rounded-4 p-3 mb-3"
                                     style="background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%); width: 80px; height: 80px;">
                                    <i class="fas fa-book-open text-white" style="font-size: 32px;"></i>
                                </div>
                            </div>

                            <h4 class="fw-bold text-dark mb-3 text-center">Ngữ Pháp</h4>
                            <p class="text-muted mb-4 text-center">
                                Học ngữ pháp tiếng Anh từ cơ bản đến nâng cao, nắm vững kiến thức nền tảng.
                            </p>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">6 khóa học</span>
                                <i class="fas fa-arrow-right text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden category-card">
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <div class="d-inline-flex align-items-center justify-content-center rounded-4 p-3 mb-3"
                                     style="background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%); width: 80px; height: 80px;">
                                    <i class="fas fa-spell-check text-white" style="font-size: 32px;"></i>
                                </div>
                            </div>

                            <h4 class="fw-bold text-dark mb-3 text-center">Từ Vựng</h4>
                            <p class="text-muted mb-4 text-center">
                                Mở rộng vốn từ vựng tiếng Anh theo chủ đề với phương pháp ghi nhớ thông minh.
                            </p>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">9 khóa học</span>
                                <i class="fas fa-arrow-right text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.backdrop-blur {
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
}

.text-white-50 {
    color: rgba(255, 255, 255, 0.7) !important;
}

/* Smooth scroll */
html {
    scroll-behavior: smooth;
}

/* Hover effects */
.btn:hover {
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    transition: all 0.3s ease;
}

.category-card:hover {
    transform: translateY(-8px);
    transition: all 0.3s ease;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
}

.category-card:hover .fa-arrow-right {
    transform: translateX(5px);
    transition: all 0.3s ease;
}

/* Gradient text support for older browsers */
@supports not (-webkit-background-clip: text) {
    .gradient-text {
        color: #FCD34D;
    }
}

/* Floating animation for hero elements */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.position-absolute .bg-warning,
.position-absolute .bg-success {
    animation: float 3s ease-in-out infinite;
}

.position-absolute .bg-success {
    animation-delay: 1.5s;
}

/* Course card hover effects */
.card .btn {
    transition: all 0.3s ease;
}

.card:hover .btn {
    background: linear-gradient(135deg, #3B82F6 0%, #8B5CF6 100%) !important;
    border: none;
}

/* Badge animations */
.badge {
    transition: all 0.3s ease;
}

.card:hover .badge {
    transform: scale(1.05);
}

/* Star rating hover */
.text-warning {
    transition: all 0.3s ease;
}

.card:hover .text-warning {
    transform: scale(1.1);
}
</style>
@endpush
