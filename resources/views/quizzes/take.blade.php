@extends('layouts.app')

@section('title', 'Làm Quiz: ' . $quiz->title)

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- Enhanced Quiz Header -->
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-gradient-primary text-white">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="mb-0">
                                <i class="fas fa-question-circle me-2"></i>
                                {{ $quiz->title }}
                            </h4>
                            <small class="text-white-50">
                                <i class="fas fa-user me-1"></i>
                                {{ Auth::user()->name }}
                            </small>
                        </div>
                        <div class="col-md-4 text-end">
                            @if($quiz->time_limit)
                                <div class="timer-container">
                                    <div class="timer-display">
                                        <i class="fas fa-stopwatch me-2"></i>
                                        <span id="time-remaining" class="timer-text">{{ $quiz->time_limit }}:00</span>
                                    </div>
                                    <div class="timer-progress mt-2">
                                        <div class="progress" style="height: 4px;">
                                            <div class="progress-bar bg-warning" id="time-progress" role="progressbar" style="width: 100%"></div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Question Navigation Sidebar -->
                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="fas fa-list me-2"></i>
                                Danh sách câu hỏi
                            </h6>
                        </div>
                        <div class="card-body p-2">
                            <div class="question-nav">
                                @for($i = 0; $i < $questions->count(); $i++)
                                <button type="button" class="btn btn-question-nav {{ $i === 0 ? 'active' : '' }}" 
                                        onclick="showQuestion({{ $i }})" data-question="{{ $i }}">
                                    {{ $i + 1 }}
                                </button>
                                @endfor
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quiz Info -->
                    <div class="card shadow-sm border-0 mt-3">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                Thông tin
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="info-item">
                                <i class="fas fa-clock text-warning me-2"></i>
                                <span>Thời gian: {{ $quiz->time_limit }} phút</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-star text-info me-2"></i>
                                <span>Điểm đạt: {{ $quiz->passing_score }}%</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-question text-primary me-2"></i>
                                <span>Tổng câu: {{ $questions->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Quiz Content -->
                <div class="col-md-9">
                    <div class="card shadow-lg border-0">
                        <div class="card-header bg-light">
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-gradient-info progress-bar-striped progress-bar-animated" 
                                     role="progressbar" style="width: 0%" id="progress-bar">
                                </div>
                            </div>
                            <div class="text-center mt-2">
                                <small class="text-muted">Tiến độ: <span id="progress-text">0 / {{ $questions->count() }}</span></small>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('quizzes.submit', $attempt) }}" id="quiz-form">
                                @csrf
                                
                                @foreach($questions as $index => $question)
                                    <div class="question-container mb-4 {{ $index === 0 ? 'active' : 'd-none' }}" data-question="{{ $index }}">
                                        <div class="question-card">
                                            <div class="question-header">
                                                <div class="question-number">
                                                    <span class="badge bg-primary">Câu {{ $index + 1 }}</span>
                                                </div>
                                                <div class="question-points">
                                                    <span class="badge bg-secondary">{{ $question->points }} điểm</span>
                                                </div>
                                            </div>
                                            
                                            <div class="question-content">
                                                <h5 class="question-text">{{ $question->question }}</h5>
                                                @if($question->image)
                                                    <img src="{{ $question->image }}" class="img-fluid mb-3 rounded" alt="Question image">
                                                @endif
                                            </div>

                                            <div class="answers-container">
                                                @foreach($question->answers as $answer)
                                                    <div class="answer-option">
                                                        <input class="form-check-input" type="radio" 
                                                               name="answers[{{ $question->id }}]" 
                                                               id="answer_{{ $question->id }}_{{ $answer->id }}"
                                                               value="{{ $answer->id }}">
                                                        <label class="answer-label" for="answer_{{ $question->id }}_{{ $answer->id }}">
                                                            <span class="answer-text">{{ $answer->answer }}</span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Navigation Controls -->
                                <div class="quiz-navigation">
                                    <div class="nav-left">
                                        <button type="button" class="btn btn-outline-secondary btn-lg prev-btn" id="prev-btn" disabled>
                                            <i class="fas fa-chevron-left me-2"></i>
                                            Câu trước
                                        </button>
                                    </div>
                                    
                                    <div class="nav-center">
                                        <span class="question-counter">
                                            <span id="current-question">1</span> / {{ $questions->count() }}
                                        </span>
                                    </div>
                                    
                                    <div class="nav-right">
                                        <button type="button" class="btn btn-primary btn-lg next-btn" id="next-btn">
                                            Câu tiếp theo
                                            <i class="fas fa-chevron-right ms-2"></i>
                                        </button>
                                        
                                        <button type="submit" class="btn btn-success btn-lg d-none" id="submit-btn">
                                            <i class="fas fa-paper-plane me-2"></i>
                                            Nộp bài
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const questions = document.querySelectorAll('.question-container');
    const totalQuestions = questions.length;
    let currentQuestion = 0;
    
    // Timer functionality
    @if($quiz->time_limit)
        let timeRemaining = {{ $quiz->time_limit * 60 }}; // Convert to seconds
        const timerElement = document.getElementById('time-remaining');
        const timeProgressBar = document.getElementById('time-progress');
        const initialTime = {{ $quiz->time_limit * 60 }};
        
        const timer = setInterval(function() {
            const minutes = Math.floor(timeRemaining / 60);
            const seconds = timeRemaining % 60;
            timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
            
            // Update time progress bar
            const timeProgress = (timeRemaining / initialTime) * 100;
            timeProgressBar.style.width = timeProgress + '%';
            
            // Change color based on time remaining
            if (timeProgress <= 20) {
                timeProgressBar.className = 'progress-bar bg-danger';
            } else if (timeProgress <= 50) {
                timeProgressBar.className = 'progress-bar bg-warning';
            } else {
                timeProgressBar.className = 'progress-bar bg-success';
            }
            
            if (timeRemaining <= 0) {
                clearInterval(timer);
                document.getElementById('quiz-form').submit();
            }
            timeRemaining--;
        }, 1000);
    @endif
    
    // Progress bar update
    function updateProgress() {
        const answered = document.querySelectorAll('input[type="radio"]:checked').length;
        const progress = (answered / totalQuestions) * 100;
        document.getElementById('progress-bar').style.width = progress + '%';
        document.getElementById('progress-text').textContent = `${answered} / ${totalQuestions}`;
        
        // Update question nav buttons
        updateQuestionNavButtons();
    }
    
    // Update question navigation buttons
    function updateQuestionNavButtons() {
        const navButtons = document.querySelectorAll('.btn-question-nav');
        navButtons.forEach((btn, index) => {
            const questionInput = document.querySelector(`input[name="answers[${questions[index].querySelector('input').name.match(/\[(.*?)\]/)[1]}]"]:checked`);
            if (questionInput) {
                btn.classList.add('answered');
                btn.classList.remove('btn-outline-secondary');
                btn.classList.add('btn-success');
            } else {
                btn.classList.remove('answered', 'btn-success');
                btn.classList.add('btn-outline-secondary');
            }
        });
    }
    
    // Navigation
    function showQuestion(index) {
        currentQuestion = index;
        
        questions.forEach((q, i) => {
            q.classList.toggle('active', i === index);
            q.classList.toggle('d-none', i !== index);
        });
        
        // Update navigation buttons
        document.getElementById('prev-btn').disabled = index === 0;
        document.getElementById('current-question').textContent = index + 1;
        
        const nextBtn = document.getElementById('next-btn');
        const submitBtn = document.getElementById('submit-btn');
        
        if (index === totalQuestions - 1) {
            nextBtn.classList.add('d-none');
            submitBtn.classList.remove('d-none');
        } else {
            nextBtn.classList.remove('d-none');
            submitBtn.classList.add('d-none');
        }
        
        // Update question nav active state
        document.querySelectorAll('.btn-question-nav').forEach((btn, i) => {
            btn.classList.toggle('active', i === index);
        });
        
        updateProgress();
    }
    
    // Event listeners
    document.getElementById('next-btn').addEventListener('click', function() {
        if (currentQuestion < totalQuestions - 1) {
            showQuestion(currentQuestion + 1);
        }
    });
    
    document.getElementById('prev-btn').addEventListener('click', function() {
        if (currentQuestion > 0) {
            showQuestion(currentQuestion - 1);
        }
    });
    
    // Auto-advance on answer selection (optional)
    document.addEventListener('change', function(e) {
        if (e.target.type === 'radio') {
            updateProgress();
            
            // Auto-advance to next question after short delay
            setTimeout(function() {
                if (currentQuestion < totalQuestions - 1) {
                    showQuestion(currentQuestion + 1);
                }
            }, 800);
        }
    });
    
    // Form submission confirmation
    document.getElementById('quiz-form').addEventListener('submit', function(e) {
        if (!confirm('Bạn có chắc muốn nộp bài không? Bạn sẽ không thể thay đổi đáp án sau khi nộp.')) {
            e.preventDefault();
        }
    });
    
    // Initial setup
    showQuestion(0);
});
</script>

<style>
/* Custom styles for enhanced quiz interface */
.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

.timer-container {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    padding: 15px;
}

.timer-text {
    font-size: 1.2em;
    font-weight: bold;
    color: #fff;
}

.question-nav {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(40px, 1fr));
    gap: 8px;
}

.btn-question-nav {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    border: 2px solid #6c757d;
    background: white;
    color: #6c757d;
    transition: all 0.3s ease;
}

.btn-question-nav:hover {
    background: #f8f9fa;
    border-color: #007bff;
    color: #007bff;
    transform: scale(1.1);
}

.btn-question-nav.active {
    background: #007bff;
    border-color: #007bff;
    color: white;
    transform: scale(1.1);
}

.btn-question-nav.answered {
    background: #28a745;
    border-color: #28a745;
    color: white;
}

.info-item {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    padding: 8px;
    background: #f8f9fa;
    border-radius: 5px;
}

.question-card {
    background: #fff;
    border-radius: 15px;
    padding: 30px;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.question-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.question-text {
    font-size: 1.25em;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 25px;
    line-height: 1.6;
}

.answers-container {
    display: grid;
    gap: 15px;
}

.answer-option {
    position: relative;
    display: flex;
    align-items: center;
    background: #f8f9fa;
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 15px 20px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.answer-option:hover {
    background: #e9ecef;
    border-color: #007bff;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.answer-option input[type="radio"] {
    margin-right: 15px;
    transform: scale(1.2);
}

.answer-option input[type="radio"]:checked + .answer-label {
    color: #007bff;
    font-weight: 600;
}

.answer-option:has(input[type="radio"]:checked) {
    background: #e7f3ff;
    border-color: #007bff;
}

.answer-label {
    cursor: pointer;
    margin: 0;
    flex: 1;
    font-size: 1.1em;
    color: #495057;
    transition: color 0.3s ease;
}

.answer-text {
    display: block;
    line-height: 1.5;
}

.quiz-navigation {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 40px;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 10px;
}

.nav-left, .nav-right {
    flex: 1;
}

.nav-right {
    text-align: right;
}

.nav-center {
    text-align: center;
}

.question-counter {
    font-size: 1.2em;
    font-weight: bold;
    color: #495057;
    background: white;
    padding: 8px 16px;
    border-radius: 20px;
    border: 2px solid #dee2e6;
}

.btn-lg {
    padding: 12px 30px;
    font-size: 1.1em;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-lg:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.card {
    border: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.card-header {
    border-bottom: 1px solid #e9ecef;
}

.progress-bar-animated {
    animation: progress-bar-stripes 1s linear infinite;
}

@keyframes progress-bar-stripes {
    0% { background-position: 0 0; }
    100% { background-position: 40px 0; }
}
</style>
@endpush
@endsection