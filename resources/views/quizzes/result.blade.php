@extends('layouts.app')

@section('title', 'Kết quả Quiz: ' . $quiz->title)

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Result Summary -->
            <div class="card mb-4">
                <div class="card-header bg-{{ $attempt->is_passed ? 'success' : 'danger' }} text-white">
                    <h3 class="mb-0">
                        <i class="fas fa-{{ $attempt->is_passed ? 'check-circle' : 'times-circle' }} me-2"></i>
                        Kết quả Quiz: {{ $quiz->title }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h2 class="text-center mb-3">
                                <span class="badge bg-{{ $attempt->is_passed ? 'success' : 'danger' }} fs-1">
                                    {{ $attempt->score_percentage }}%
                                </span>
                            </h2>
                            <div class="text-center">
                                @if($attempt->is_passed)
                                    <h4 class="text-success">🎉 Chúc mừng! Bạn đã đạt</h4>
                                    <p class="text-muted">Bạn đã vượt qua điểm qua {{ $quiz->passing_score }}%</p>
                                @else
                                    <h4 class="text-danger">😔 Chưa đạt</h4>
                                    <p class="text-muted">Bạn cần đạt tối thiểu {{ $quiz->passing_score }}% để qua bài</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5>Thông tin chi tiết</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-score me-2"></i>Điểm số: {{ $attempt->score }}/{{ $attempt->total_points }}</li>
                                <li><i class="fas fa-percentage me-2"></i>Tỷ lệ đúng: {{ $attempt->score_percentage }}%</li>
                                <li><i class="fas fa-clock me-2"></i>Thời gian làm bài: {{ $attempt->formatted_duration }}</li>
                                <li><i class="fas fa-calendar me-2"></i>Ngày làm: {{ $attempt->completed_at->format('d/m/Y H:i') }}</li>
                                <li><i class="fas fa-questions me-2"></i>Số câu hỏi: {{ $questions->count() }}</li>
                                <li><i class="fas fa-check-circle me-2"></i>Câu đúng: {{ $questions->filter(function($q) use ($attempt) { return $q->isCorrectAnswer($attempt->answers[$q->id] ?? ''); })->count() }}</li>
                                <li><i class="fas fa-times-circle me-2"></i>Câu sai: {{ $questions->count() - $questions->filter(function($q) use ($attempt) { return $q->isCorrectAnswer($attempt->answers[$q->id] ?? ''); })->count() }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Results -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>Chi tiết từng câu hỏi
                    </h5>
                </div>
                <div class="card-body">
                    @foreach($questions as $index => $question)
                        @php
                            $userAnswer = $attempt->answers[$question->id] ?? null;
                            $isCorrect = $question->isCorrectAnswer($userAnswer);
                            $correctAnswer = $question->correctAnswers()->first();
                        @endphp
                        
                        <div class="question-result mb-4 p-3 border rounded {{ $isCorrect ? 'border-success bg-light-success' : 'border-danger bg-light-danger' }}">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">
                                    <span class="badge bg-{{ $isCorrect ? 'success' : 'danger' }}">
                                        {{ $index + 1 }}
                                    </span>
                                    {{ $question->question }}
                                </h6>
                                <span class="badge bg-secondary">{{ $question->points }} điểm</span>
                            </div>
                            
                            @if($question->image)
                                <img src="{{ $question->image }}" class="img-fluid mb-3" alt="Question image" style="max-height: 200px;">
                            @endif
                            
                            <div class="answers">
                                @foreach($question->answers as $answer)
                                    <div class="form-check mb-1">
                                        <input type="radio" class="form-check-input" disabled 
                                               {{ $userAnswer == $answer->id ? 'checked' : '' }}>
                                        <label class="form-check-label">
                                            {{ $answer->answer }}
                                            @if($answer->is_correct)
                                                <span class="badge bg-success ms-2">Đáp án đúng</span>
                                            @elseif($userAnswer == $answer->id && !$answer->is_correct)
                                                <span class="badge bg-danger ms-2">Bạn đã chọn</span>
                                            @endif
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            
                            @if(!$userAnswer)
                                <div class="mt-2">
                                    <span class="badge bg-warning">Bạn chưa trả lời câu này</span>
                                </div>
                            @endif
                            
                            @if($question->explanation)
                                <div class="mt-3 p-2 bg-info bg-opacity-10 rounded">
                                    <strong>Giải thích:</strong> {{ $question->explanation }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Actions -->
            <div class="text-center mt-4">
                <a href="{{ route('quizzes.show', $quiz) }}" class="btn btn-primary">
                    <i class="fas fa-redo me-2"></i>Làm lại Quiz
                </a>
                <a href="{{ route('lessons.show', $quiz->lesson) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại bài học
                </a>
                <a href="{{ route('courses.show', $quiz->lesson->course) }}" class="btn btn-info">
                    <i class="fas fa-book me-2"></i>Xem khóa học
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.bg-light-success {
    background-color: #d4edda !important;
}

.bg-light-danger {
    background-color: #f8d7da !important;
}
</style>
@endsection