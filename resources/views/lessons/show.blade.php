@extends('layouts.app')

@section('title', $lesson->title . ' - ' . $course->title)

@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar - Course Navigation -->
        <div class="col-md-3 bg-light border-end" style="min-height: 100vh;">
            <div class="p-3">
                <div class="d-flex align-items-center mb-3">
                    <a href="{{ route('courses.show', $course->slug) }}" class="btn btn-outline-primary btn-sm me-2">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h6 class="mb-0">{{ $course->title }}</h6>
                </div>
                
                <div class="progress mb-3" style="height: 8px;">
                    @php
                        $userProgress = auth()->user()->enrollments()
                            ->where('course_id', $course->id)
                            ->first()->progress ?? 0;
                    @endphp
                    <div class="progress-bar" role="progressbar" style="width: {{ $userProgress }}%"></div>
                </div>
                <small class="text-muted">Tiến độ: {{ $userProgress }}%</small>
            </div>

            <div class="list-group list-group-flush">
                @foreach($lessons as $index => $courseLesson)
                    <div class="list-group-item {{ $courseLesson->id === $lesson->id ? 'active' : '' }} p-3">
                        <div class="d-flex align-items-start">
                            <div class="me-3">
                                @if(auth()->user()->completedLessons()->where('lesson_id', $courseLesson->id)->exists())
                                    <i class="fas fa-check-circle text-success"></i>
                                @else
                                    <i class="far fa-circle text-muted"></i>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <a href="{{ route('lessons.show', $courseLesson->slug) }}" 
                                   class="text-decoration-none {{ $courseLesson->id === $lesson->id ? 'text-white' : 'text-dark' }}">
                                    <div class="fw-bold">{{ $index + 1 }}. {{ $courseLesson->title }}</div>
                                    <small class="{{ $courseLesson->id === $lesson->id ? 'text-white-50' : 'text-muted' }}">
                                        {{ $courseLesson->duration }} phút
                                    </small>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="p-4">
                <!-- Lesson Header -->
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h1 class="h3">{{ $lesson->title }}</h1>
                        <div class="text-muted">
                            <i class="fas fa-clock me-1"></i>{{ $lesson->duration }} phút
                            <span class="mx-2">•</span>
                            <i class="fas fa-book me-1"></i>{{ $course->title }}
                        </div>
                    </div>
                    
                    <div>
                        @if(!auth()->user()->completedLessons()->where('lesson_id', $lesson->id)->exists())
                            <button class="btn btn-success" id="completeBtn" onclick="markAsCompleted({{ $lesson->id }})">
                                <i class="fas fa-check me-2"></i>Đánh dấu hoàn thành
                            </button>
                        @else
                            <span class="badge bg-success fs-6">
                                <i class="fas fa-check me-1"></i>Đã hoàn thành
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Video Player (if available) -->
                @if($lesson->video_url)
                    <div class="mb-4">
                        <div class="ratio ratio-16x9">
                            @if(str_contains($lesson->video_url, 'youtube.com') || str_contains($lesson->video_url, 'youtu.be'))
                                @php
                                    $videoId = '';
                                    if (str_contains($lesson->video_url, 'youtube.com/watch?v=')) {
                                        $videoId = substr($lesson->video_url, strpos($lesson->video_url, 'v=') + 2);
                                    } elseif (str_contains($lesson->video_url, 'youtu.be/')) {
                                        $videoId = substr($lesson->video_url, strrpos($lesson->video_url, '/') + 1);
                                    }
                                    $videoId = explode('&', $videoId)[0];
                                @endphp
                                <iframe src="https://www.youtube.com/embed/{{ $videoId }}" 
                                        title="{{ $lesson->title }}" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen>
                                </iframe>
                            @else
                                <video controls class="w-100">
                                    <source src="{{ $lesson->video_url }}" type="video/mp4">
                                    Trình duyệt của bạn không hỗ trợ video.
                                </video>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Lesson Content -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Nội dung bài học</h5>
                        <div class="lesson-content">
                            {!! nl2br(e($lesson->content)) !!}
                        </div>
                    </div>
                </div>

                <!-- Quiz Section -->
                @if($lesson->quizzes && $lesson->quizzes->count() > 0)
                    <div class="card mt-4">
                        <div class="card-header bg-warning">
                            <h5 class="mb-0">
                                <i class="fas fa-quiz me-2"></i>
                                Quiz cho bài học này
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($lesson->quizzes as $quiz)
                                    <div class="col-md-6 mb-3">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h6 class="card-title">{{ $quiz->title }}</h6>
                                                @if($quiz->description)
                                                    <p class="card-text text-muted">{{ Str::limit($quiz->description, 100) }}</p>
                                                @endif
                                                <div class="row text-center mb-3">
                                                    <div class="col-4">
                                                        <small class="text-muted">Câu hỏi</small>
                                                        <div class="fw-bold">{{ $quiz->questions->count() }}</div>
                                                    </div>
                                                    <div class="col-4">
                                                        <small class="text-muted">Thời gian</small>
                                                        <div class="fw-bold">{{ $quiz->time_limit ?? 'Không giới hạn' }}</div>
                                                    </div>
                                                    <div class="col-4">
                                                        <small class="text-muted">Điểm qua</small>
                                                        <div class="fw-bold">{{ $quiz->passing_score }}%</div>
                                                    </div>
                                                </div>
                                                
                                                @php
                                                    $userAttempts = $quiz->attempts()->where('user_id', auth()->id())->get();
                                                    $bestScore = $userAttempts->map(function($attempt) {
                                                        return $attempt->score_percentage;
                                                    })->max() ?? 0;
                                                    $isPassed = $bestScore >= $quiz->passing_score;
                                                @endphp
                                                
                                                @if($userAttempts->count() > 0)
                                                    <div class="mb-2">
                                                        <small class="text-muted">Điểm cao nhất:</small>
                                                        <span class="badge bg-{{ $isPassed ? 'success' : 'warning' }} ms-1">
                                                            {{ $bestScore }}%
                                                        </span>
                                                    </div>
                                                @endif
                                                
                                                <div class="d-grid">
                                                    <a href="{{ route('quizzes.show', $quiz) }}" class="btn btn-{{ $isPassed ? 'success' : 'primary' }}">
                                                        <i class="fas fa-{{ $isPassed ? 'check' : 'play' }} me-1"></i>
                                                        {{ $userAttempts->count() > 0 ? ($isPassed ? 'Đã hoàn thành' : 'Làm lại') : 'Bắt đầu Quiz' }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Navigation -->
                <div class="d-flex justify-content-between mt-4">
                    <div>
                        @if($previousLesson)
                            <a href="{{ route('lessons.show', $previousLesson->slug) }}" class="btn btn-outline-primary">
                                <i class="fas fa-chevron-left me-2"></i>Bài trước: {{ Str::limit($previousLesson->title, 30) }}
                            </a>
                        @endif
                    </div>
                    
                    <div>
                        @if($nextLesson)
                            <a href="{{ route('lessons.show', $nextLesson->slug) }}" class="btn btn-primary">
                                Bài tiếp: {{ Str::limit($nextLesson->title, 30) }}<i class="fas fa-chevron-right ms-2"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function markAsCompleted(lessonId) {
    // Get CSRF token
    const token = document.querySelector('meta[name="csrf-token"]');
    if (!token) {
        alert('CSRF token not found!');
        return;
    }

    // Show loading state
    const btn = document.getElementById('completeBtn');
    if (!btn) {
        alert('Button not found!');
        return;
    }

    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang xử lý...';
    btn.disabled = true;

    console.log('Sending request to:', `/lessons/${lessonId}/complete`);

    fetch(`/lessons/${lessonId}/complete`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token.getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({})
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            // Update button
            btn.outerHTML = '<span class="badge bg-success fs-6"><i class="fas fa-check me-1"></i>Đã hoàn thành</span>';

            // Update progress bar
            const progressBar = document.querySelector('.progress-bar');
            if (progressBar) {
                progressBar.style.width = data.progress + '%';
                progressBar.setAttribute('aria-valuenow', data.progress);
            }

            // Update progress text
            const progressText = document.querySelector('.text-muted');
            if (progressText) {
                progressText.textContent = `Tiến độ: ${data.progress}%`;
            }

            // Update sidebar icon
            const sidebarIcon = document.querySelector(`[data-lesson-id="${lessonId}"] i`);
            if (sidebarIcon) {
                sidebarIcon.className = 'fas fa-check-circle text-success';
            }

            // Show success message
            alert(data.message || 'Bài học đã được đánh dấu hoàn thành!');
        } else {
            throw new Error(data.message || 'Unknown error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Restore button
        btn.innerHTML = originalText;
        btn.disabled = false;
        alert('Có lỗi xảy ra: ' + error.message);
    });
}
</script>
@endpush

@push('styles')
<style>
.lesson-content {
    line-height: 1.8;
    font-size: 1.1rem;
}

.list-group-item.active {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.list-group-item:hover:not(.active) {
    background-color: #f8f9fa;
}
</style>
@endpush
@endsection
