@extends('layouts.adminlte-pure')

@section('title', 'Chỉnh sửa Quiz - Admin')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Chỉnh sửa Quiz</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.quizzes.index') }}">Quiz</a></li>
                <li class="breadcrumb-item active">Chỉnh sửa</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-edit mr-1"></i>
                Chỉnh sửa Quiz: {{ $quiz->title }}
            </h3>
        </div>
        <form action="{{ route('admin.quizzes.update', $quiz) }}" method="POST" id="quiz-form">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Tiêu đề <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $quiz->title) }}" required>
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lesson_id">Bài học <span class="text-danger">*</span></label>
                            <select class="form-control select2 @error('lesson_id') is-invalid @enderror" 
                                    id="lesson_id" name="lesson_id" required>
                                <option value="">Chọn bài học</option>
                                @foreach($lessons as $lesson)
                                    <option value="{{ $lesson->id }}" {{ old('lesson_id', $quiz->lesson_id) == $lesson->id ? 'selected' : '' }}>
                                        {{ $lesson->course->title }} - {{ $lesson->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('lesson_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="time_limit">Thời gian làm bài (phút)</label>
                            <input type="number" class="form-control @error('time_limit') is-invalid @enderror" 
                                   id="time_limit" name="time_limit" value="{{ old('time_limit', $quiz->time_limit) }}" min="1">
                            @error('time_limit')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="passing_score">Điểm qua (%) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('passing_score') is-invalid @enderror" 
                                   id="passing_score" name="passing_score" value="{{ old('passing_score', $quiz->passing_score) }}" 
                                   min="0" max="100" required>
                            @error('passing_score')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Mô tả</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3">{{ old('description', $quiz->description) }}</textarea>
                    @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <hr>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Câu hỏi</h4>
                    <button type="button" class="btn btn-success" id="add-question">
                        <i class="fas fa-plus"></i> Thêm câu hỏi
                    </button>
                </div>

                <div id="questions-container">
                    @foreach($quiz->questions as $questionIndex => $question)
                        <div class="card mb-3 question-card" data-question-index="{{ $questionIndex }}">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Câu hỏi {{ $questionIndex + 1 }}</h5>
                                    <button type="button" class="btn btn-danger btn-sm remove-question">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Nội dung câu hỏi <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="questions[{{ $questionIndex }}][question]" rows="2" required>{{ $question->question }}</textarea>
                                </div>
                                <div class="answers-container">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label>Đáp án</label>
                                        <button type="button" class="btn btn-sm btn-info add-answer">
                                            <i class="fas fa-plus"></i> Thêm đáp án
                                        </button>
                                    </div>
                                    <div class="answers-list">
                                        @foreach($question->answers as $answerIndex => $answer)
                                            <div class="form-group answer-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <input type="radio" name="questions[{{ $questionIndex }}][correct_answer]" 
                                                                   value="{{ $answerIndex }}" {{ $answer->is_correct ? 'checked' : '' }} required>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control" 
                                                           name="questions[{{ $questionIndex }}][answers][{{ $answerIndex }}][answer]" 
                                                           value="{{ $answer->answer }}" placeholder="Nhập đáp án..." required>
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-outline-danger remove-answer">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.quizzes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Quay lại
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Cập nhật Quiz
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
let questionIndex = {{ $quiz->questions->count() }};

// Add question function
function addQuestion() {
    const questionsContainer = document.getElementById('questions-container');
    const questionHtml = `
        <div class="card mb-3 question-card" data-question-index="${questionIndex}">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Câu hỏi ${questionIndex + 1}</h5>
                    <button type="button" class="btn btn-danger btn-sm remove-question">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Nội dung câu hỏi <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="questions[${questionIndex}][question]" rows="2" required></textarea>
                </div>
                <div class="answers-container">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label>Đáp án</label>
                        <button type="button" class="btn btn-sm btn-info add-answer">
                            <i class="fas fa-plus"></i> Thêm đáp án
                        </button>
                    </div>
                    <div class="answers-list">
                        <!-- Answers will be added here -->
                    </div>
                </div>
            </div>
        </div>
    `;
    
    questionsContainer.insertAdjacentHTML('beforeend', questionHtml);
    
    // Add initial answers
    const newQuestionCard = questionsContainer.lastElementChild;
    addAnswer(newQuestionCard, questionIndex);
    addAnswer(newQuestionCard, questionIndex);
    
    questionIndex++;
}

// Add answer function
function addAnswer(questionCard, qIndex) {
    const answersList = questionCard.querySelector('.answers-list');
    const answerCount = answersList.children.length;
    
    const answerHtml = `
        <div class="form-group answer-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input type="radio" name="questions[${qIndex}][correct_answer]" value="${answerCount}" required>
                    </div>
                </div>
                <input type="text" class="form-control" name="questions[${qIndex}][answers][${answerCount}][answer]" placeholder="Nhập đáp án..." required>
                <div class="input-group-append">
                    <button type="button" class="btn btn-outline-danger remove-answer">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
    
    answersList.insertAdjacentHTML('beforeend', answerHtml);
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Add question button
    document.getElementById('add-question').addEventListener('click', addQuestion);
    
    // Event delegation for remove question
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-question') || e.target.closest('.remove-question')) {
            const questionCard = e.target.closest('.question-card');
            if (document.querySelectorAll('.question-card').length > 1) {
                questionCard.remove();
                updateQuestionNumbers();
            } else {
                alert('Phải có ít nhất một câu hỏi!');
            }
        }
    });
    
    // Event delegation for add answer
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('add-answer') || e.target.closest('.add-answer')) {
            const questionCard = e.target.closest('.question-card');
            const questionIndex = questionCard.dataset.questionIndex;
            addAnswer(questionCard, questionIndex);
        }
    });
    
    // Event delegation for remove answer
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-answer') || e.target.closest('.remove-answer')) {
            const answerGroup = e.target.closest('.answer-group');
            const answersList = answerGroup.parentElement;
            
            if (answersList.children.length > 2) {
                answerGroup.remove();
                updateAnswerIndices(answersList);
            } else {
                alert('Phải có ít nhất 2 đáp án!');
            }
        }
    });
    
    // Form submission
    document.getElementById('quiz-form').addEventListener('submit', function(e) {
        // Convert radio button selections to boolean values
        const questions = document.querySelectorAll('.question-card');
        
        questions.forEach((questionCard, qIndex) => {
            const answers = questionCard.querySelectorAll('.answer-group');
            const correctRadio = questionCard.querySelector('input[type="radio"]:checked');
            
            if (!correctRadio) {
                e.preventDefault();
                alert(`Vui lòng chọn đáp án đúng cho câu hỏi ${qIndex + 1}!`);
                return;
            }
            
            const correctAnswerIndex = parseInt(correctRadio.value);
            
            answers.forEach((answerGroup, aIndex) => {
                const isCorrect = aIndex === correctAnswerIndex;
                
                // Create hidden input for is_correct
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = `questions[${qIndex}][answers][${aIndex}][is_correct]`;
                hiddenInput.value = isCorrect ? '1' : '0';
                
                answerGroup.appendChild(hiddenInput);
            });
        });
    });
});

function updateQuestionNumbers() {
    const questionCards = document.querySelectorAll('.question-card');
    questionCards.forEach((card, index) => {
        card.querySelector('h5').textContent = `Câu hỏi ${index + 1}`;
        card.dataset.questionIndex = index;
        
        // Update input names
        const textarea = card.querySelector('textarea');
        textarea.name = `questions[${index}][question]`;
        
        // Update answer names
        const answers = card.querySelectorAll('.answer-group');
        answers.forEach((answerGroup, aIndex) => {
            const input = answerGroup.querySelector('input[type="text"]');
            input.name = `questions[${index}][answers][${aIndex}][answer]`;
        });
        
        // Update radio button names
        const radios = card.querySelectorAll('input[type="radio"]');
        radios.forEach(radio => {
            radio.name = `questions[${index}][correct_answer]`;
        });
    });
}

function updateAnswerIndices(answersList) {
    const answers = answersList.querySelectorAll('.answer-group');
    const questionCard = answersList.closest('.question-card');
    const questionIndex = questionCard.dataset.questionIndex;
    
    answers.forEach((answerGroup, index) => {
        const input = answerGroup.querySelector('input[type="text"]');
        input.name = `questions[${questionIndex}][answers][${index}][answer]`;
        
        const radio = answerGroup.querySelector('input[type="radio"]');
        radio.value = index;
    });
}
</script>
@endpush