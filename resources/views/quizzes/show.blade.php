@extends('layouts.app')

@section('title', $quiz->title)

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">
                        <i class="fas fa-quiz me-2"></i>
                        {{ $quiz->title }}
                    </h3>
                </div>
                <div class="card-body">
                    @if($quiz->description)
                        <p class="text-muted mb-4">{{ $quiz->description }}</p>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Thông tin Quiz</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-book me-2"></i>Bài học: {{ $quiz->lesson->title }}</li>
                                <li><i class="fas fa-questions me-2"></i>Số câu hỏi: {{ $quiz->questions->count() }}</li>
                                @if($quiz->time_limit)
                                    <li><i class="fas fa-clock me-2"></i>Thời gian: {{ $quiz->time_limit }} phút</li>
                                @endif
                                <li><i class="fas fa-trophy me-2"></i>Điểm qua: {{ $quiz->passing_score }}%</li>
                                @if($quiz->max_attempts)
                                    <li><i class="fas fa-redo me-2"></i>Số lần thử tối đa: {{ $quiz->max_attempts }}</li>
                                @endif
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>Kết quả của bạn</h5>
                            @if($attempts->count() > 0)
                                <div class="mb-2">
                                    <strong>Điểm cao nhất:</strong> 
                                    <span class="badge bg-{{ $bestScore >= $quiz->passing_score ? 'success' : 'warning' }}">
                                        {{ $bestScore }}%
                                    </span>
                                </div>
                                <div class="mb-2">
                                    <strong>Đã thử:</strong> {{ $attempts->count() }} {{ $quiz->max_attempts ? '/ ' . $quiz->max_attempts : '' }} lần
                                </div>
                                <div class="mb-2">
                                    <strong>Trạng thái:</strong> 
                                    @if($bestScore >= $quiz->passing_score)
                                        <span class="badge bg-success">Đã đạt</span>
                                    @else
                                        <span class="badge bg-warning">Chưa đạt</span>
                                    @endif
                                </div>
                            @else
                                <p class="text-muted">Bạn chưa thử làm quiz này</p>
                            @endif
                        </div>
                    </div>

                    @if($attempts->count() > 0)
                        <div class="mb-4">
                            <h5>Lịch sử làm bài</h5>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Lần thử</th>
                                            <th>Điểm</th>
                                            <th>Thời gian</th>
                                            <th>Ngày làm</th>
                                            <th>Kết quả</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($attempts as $index => $attempt)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $attempt->is_passed ? 'success' : 'danger' }}">
                                                        {{ $attempt->score_percentage }}%
                                                    </span>
                                                </td>
                                                <td>{{ $attempt->formatted_duration }}</td>
                                                <td>{{ $attempt->completed_at ? $attempt->completed_at->format('d/m/Y H:i') : 'Chưa hoàn thành' }}</td>
                                                <td>
                                                    @if($attempt->is_passed)
                                                        <span class="badge bg-success">Đạt</span>
                                                    @else
                                                        <span class="badge bg-danger">Không đạt</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($attempt->completed_at)
                                                        <a href="{{ route('quizzes.result', $attempt) }}" class="btn btn-sm btn-info">
                                                            <i class="fas fa-eye me-1"></i>Xem kết quả
                                                        </a>
                                                    @else
                                                        <span class="text-muted">Chưa hoàn thành</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <div class="text-center">
                        @if($canAttempt)
                            <form method="POST" action="{{ route('quizzes.start', $quiz) }}">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-play me-2"></i>
                                    {{ $attempts->count() > 0 ? 'Làm lại Quiz' : 'Bắt đầu Quiz' }}
                                </button>
                            </form>
                        @else
                            <p class="text-muted">Bạn đã hết lượt làm bài quiz này.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-3 text-center">
                <a href="{{ route('lessons.show', $quiz->lesson) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại bài học
                </a>
            </div>
        </div>
    </div>
</div>
@endsection