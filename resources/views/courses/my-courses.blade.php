@extends('layouts.app')

@section('title', 'Khóa Học Của Tôi')

@section('content')
<div class="container py-5">
    <!-- Page Header -->
    <div class="row mb-5">
        <div class="col-12">
            <h1 class="display-4 fw-bold text-center">
                <i class="fas fa-graduation-cap me-3 text-primary"></i>
                Khóa Học Của Tôi
            </h1>
            <p class="lead text-center text-muted">Theo dõi tiến độ học tập và tiếp tục hành trình học tiếng Anh</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-5">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <i class="fas fa-book fa-2x mb-2"></i>
                    <h4>{{ $enrollments->total() }}</h4>
                    <p class="mb-0">Tổng khóa học</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-2x mb-2"></i>
                    <h4>{{ $enrollments->where('completed_at', '!=', null)->count() }}</h4>
                    <p class="mb-0">Đã hoàn thành</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <i class="fas fa-clock fa-2x mb-2"></i>
                    <h4>{{ $enrollments->where('completed_at', null)->count() }}</h4>
                    <p class="mb-0">Đang học</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <i class="fas fa-chart-line fa-2x mb-2"></i>
                    <h4>{{ number_format($enrollments->avg('progress_percentage'), 1) }}%</h4>
                    <p class="mb-0">Tiến độ TB</p>
                </div>
            </div>
        </div>
    </div>

    <!-- My Courses -->
    @if($enrollments->count() > 0)
        <div class="row g-4">
            @foreach($enrollments as $enrollment)
                @php
                    $course = $enrollment->course;
                    $progress = $enrollment->progress_percentage ?? 0;
                    $isCompleted = $enrollment->completed_at !== null;
                @endphp
                
                <div class="col-lg-4 col-md-6">
                    <div class="card course-card h-100 {{ $isCompleted ? 'border-success' : '' }}">
                        @if($isCompleted)
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-success">
                                    <i class="fas fa-check me-1"></i>Hoàn thành
                                </span>
                            </div>
                        @endif
                        
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
                            <p class="card-text text-muted small flex-grow-1">
                                {{ Str::limit($course->short_description, 100) }}
                            </p>
                            
                            <!-- Progress Bar -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <small class="text-muted">Tiến độ</small>
                                    <small class="text-muted">{{ number_format($progress, 1) }}%</small>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar {{ $isCompleted ? 'bg-success' : 'bg-primary' }}" 
                                         role="progressbar" 
                                         style="width: {{ $progress }}%"
                                         aria-valuenow="{{ $progress }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Course Info -->
                            <div class="row text-center mb-3">
                                <div class="col-4">
                                    <small class="text-muted">Bài học</small>
                                    <div class="fw-bold">{{ $course->lessons->count() }}</div>
                                </div>
                                <div class="col-4">
                                    <small class="text-muted">Thời lượng</small>
                                    <div class="fw-bold">{{ $course->duration_hours }}h</div>
                                </div>
                                <div class="col-4">
                                    <small class="text-muted">Đăng ký</small>
                                    <div class="fw-bold">{{ $enrollment->enrolled_at->format('d/m/Y') }}</div>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="mt-auto">
                                @if($course->lessons->count() > 0)
                                    @php
                                        $firstLesson = $course->lessons->first();
                                        $lastCompletedLesson = auth()->user()->completedLessons()
                                            ->where('course_id', $course->id)
                                            ->orderBy('lesson_user.created_at', 'desc')
                                            ->first();
                                        $nextLesson = $lastCompletedLesson 
                                            ? $course->lessons->where('order', '>', $lastCompletedLesson->order)->first()
                                            : $firstLesson;
                                        $continueLesson = $nextLesson ?? $firstLesson;
                                    @endphp
                                    
                                    <a href="{{ route('lessons.show', $continueLesson->slug) }}" 
                                       class="btn btn-primary w-100 mb-2">
                                        <i class="fas fa-play me-2"></i>
                                        {{ $progress > 0 ? 'Tiếp tục học' : 'Bắt đầu học' }}
                                    </a>
                                @endif
                                
                                <a href="{{ route('courses.show', $course->slug) }}" 
                                   class="btn btn-outline-primary w-100">
                                    <i class="fas fa-info-circle me-2"></i>Chi tiết khóa học
                                </a>
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
                    {{ $enrollments->links() }}
                </div>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-graduation-cap fa-5x text-muted mb-4"></i>
                    <h3>Bạn chưa đăng ký khóa học nào</h3>
                    <p class="text-muted mb-4">Hãy khám phá và đăng ký các khóa học tiếng Anh phong phú của chúng tôi</p>
                    <a href="{{ route('courses.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-search me-2"></i>Khám phá khóa học
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.course-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    border: 1px solid #e9ecef;
}

.course-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.progress {
    border-radius: 10px;
}

.progress-bar {
    border-radius: 10px;
}

.badge {
    font-size: 0.75rem;
}
</style>
@endsection
