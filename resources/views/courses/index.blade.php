@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Page Header -->
    <div class="row mb-5">
        <div class="col-12">
            <h1 class="display-4 fw-bold text-center">Tất Cả Khóa Học</h1>
            <p class="lead text-center text-muted">Khám phá các khóa học tiếng Anh phong phú và chất lượng</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('courses.index') }}">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Danh mục</label>
                                <select name="category" class="form-select">
                                    <option value="">Tất cả danh mục</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Cấp độ</label>
                                <select name="level" class="form-select">
                                    <option value="">Tất cả cấp độ</option>
                                    <option value="beginner" {{ request('level') == 'beginner' ? 'selected' : '' }}>Cơ bản</option>
                                    <option value="intermediate" {{ request('level') == 'intermediate' ? 'selected' : '' }}>Trung cấp</option>
                                    <option value="advanced" {{ request('level') == 'advanced' ? 'selected' : '' }}>Nâng cao</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Giá</label>
                                <select name="price" class="form-select">
                                    <option value="">Tất cả</option>
                                    <option value="free" {{ request('price') == 'free' ? 'selected' : '' }}>Miễn phí</option>
                                    <option value="paid" {{ request('price') == 'paid' ? 'selected' : '' }}>Có phí</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tìm kiếm</label>
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Tìm khóa học..." value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Courses Grid -->
    @if($courses->count() > 0)
        <div class="row g-4">
            @foreach($courses as $course)
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
                            <div>
                                <span class="badge bg-secondary">{{ ucfirst($course->level) }}</span>
                                @if($course->is_featured)
                                    <span class="badge bg-warning">Nổi bật</span>
                                @endif
                            </div>
                        </div>
                        <h5 class="card-title">{{ $course->title }}</h5>
                        <p class="card-text text-muted flex-grow-1">{{ Str::limit($course->short_description, 100) }}</p>
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">
                                    <i class="fas fa-user me-1"></i>{{ $course->instructor->name }}
                                </small>
                                <small class="text-muted">
                                    <i class="fas fa-users me-1"></i>{{ $course->student_count }} học viên
                                </small>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>{{ $course->duration_hours }}h
                                </small>
                                <small class="text-muted">
                                    <i class="fas fa-book-open me-1"></i>{{ $course->lesson_count }} bài học
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

        <!-- Pagination -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $courses->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-search fa-5x text-muted mb-4"></i>
                    <h3>Không tìm thấy khóa học nào</h3>
                    <p class="text-muted">Hãy thử thay đổi bộ lọc hoặc từ khóa tìm kiếm</p>
                    <a href="{{ route('courses.index') }}" class="btn btn-primary">
                        Xem Tất Cả Khóa Học
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
