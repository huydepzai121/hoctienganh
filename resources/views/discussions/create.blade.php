@extends('layouts.app')

@section('title', 'Tạo thảo luận mới')

@push('styles')
<style>
.create-form-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.form-group label {
    font-weight: 600;
    color: #495057;
}

.form-control {
    border-radius: 8px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.category-option {
    padding: 0.75rem;
    border: 2px solid #e9ecef;
    border-radius: 10px;
    margin-bottom: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.category-option:hover {
    border-color: #007bff;
    background-color: #f8f9fa;
}

.category-option.selected {
    border-color: #007bff;
    background-color: #e3f2fd;
}

.category-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin-right: 1rem;
}

.submit-btn {
    background: linear-gradient(135deg, #28a745, #20c997);
    border: none;
    border-radius: 25px;
    padding: 0.75rem 2rem;
    color: white;
    font-weight: 600;
    transition: all 0.3s ease;
}

.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
    color: white;
}

.cancel-btn {
    border: 2px solid #6c757d;
    border-radius: 25px;
    padding: 0.75rem 2rem;
    color: #6c757d;
    font-weight: 600;
    transition: all 0.3s ease;
}

.cancel-btn:hover {
    background-color: #6c757d;
    color: white;
}

.editor-toolbar {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-bottom: none;
    border-radius: 8px 8px 0 0;
    padding: 0.5rem;
}

.editor-btn {
    border: none;
    background: none;
    padding: 0.25rem 0.5rem;
    margin: 0 0.25rem;
    border-radius: 4px;
    color: #6c757d;
    transition: all 0.3s ease;
}

.editor-btn:hover {
    background-color: #e9ecef;
    color: #495057;
}

.content-editor {
    border-radius: 0 0 8px 8px !important;
    border-top: none !important;
    min-height: 200px;
}

.tips-card {
    background: linear-gradient(135deg, #e3f2fd, #bbdefb);
    border: none;
    border-radius: 15px;
    padding: 1.5rem;
}

.tips-title {
    color: #1976d2;
    font-weight: 600;
    margin-bottom: 1rem;
}

.tip-item {
    margin-bottom: 0.5rem;
    color: #424242;
}
</style>
@endpush

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <div class="create-form-card card">
                <div class="card-header bg-white">
                    <h4 class="mb-0">
                        <i class="fas fa-plus-circle text-primary mr-2"></i>
                        Tạo thảo luận mới
                    </h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('discussions.store') }}">
                        @csrf
                        
                        <!-- Title -->
                        <div class="form-group">
                            <label for="title">
                                <i class="fas fa-heading mr-1"></i>Tiêu đề thảo luận *
                            </label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}" 
                                   placeholder="Nhập tiêu đề thảo luận của bạn..."
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Category Selection -->
                        <div class="form-group">
                            <label>
                                <i class="fas fa-folder mr-1"></i>Chọn danh mục *
                            </label>
                            <div class="row">
                                @foreach($categories as $category)
                                    <div class="col-md-6 mb-2">
                                        <div class="category-option" data-category="{{ $category->id }}">
                                            <div class="d-flex align-items-center">
                                                <div class="category-icon" style="background-color: {{ $category->color }}">
                                                    @if($category->icon)
                                                        <i class="{{ $category->icon }}"></i>
                                                    @else
                                                        <i class="fas fa-folder"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="font-weight-bold">{{ $category->name }}</div>
                                                    @if($category->description)
                                                        <small class="text-muted">{{ $category->description }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <input type="hidden" 
                                   name="discussion_category_id" 
                                   id="discussion_category_id" 
                                   value="{{ old('discussion_category_id') }}"
                                   class="@error('discussion_category_id') is-invalid @enderror">
                            @error('discussion_category_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Course Selection -->
                        <div class="form-group">
                            <label for="course_id">
                                <i class="fas fa-book mr-1"></i>Khóa học liên quan (tùy chọn)
                            </label>
                            <select class="form-control @error('course_id') is-invalid @enderror" 
                                    id="course_id" 
                                    name="course_id">
                                <option value="">Chọn khóa học (nếu có)</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" 
                                            {{ old('course_id', $selectedCourse) == $course->id ? 'selected' : '' }}>
                                        {{ $course->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('course_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Content -->
                        <div class="form-group">
                            <label for="content">
                                <i class="fas fa-edit mr-1"></i>Nội dung thảo luận *
                            </label>
                            <div class="editor-toolbar">
                                <button type="button" class="editor-btn" onclick="formatText('bold')">
                                    <i class="fas fa-bold"></i>
                                </button>
                                <button type="button" class="editor-btn" onclick="formatText('italic')">
                                    <i class="fas fa-italic"></i>
                                </button>
                                <button type="button" class="editor-btn" onclick="formatText('underline')">
                                    <i class="fas fa-underline"></i>
                                </button>
                                <span class="mx-2">|</span>
                                <button type="button" class="editor-btn" onclick="insertList('ul')">
                                    <i class="fas fa-list-ul"></i>
                                </button>
                                <button type="button" class="editor-btn" onclick="insertList('ol')">
                                    <i class="fas fa-list-ol"></i>
                                </button>
                                <span class="mx-2">|</span>
                                <button type="button" class="editor-btn" onclick="insertLink()">
                                    <i class="fas fa-link"></i>
                                </button>
                                <button type="button" class="editor-btn" onclick="insertCode()">
                                    <i class="fas fa-code"></i>
                                </button>
                            </div>
                            <textarea class="form-control content-editor @error('content') is-invalid @enderror" 
                                      id="content" 
                                      name="content" 
                                      rows="8" 
                                      placeholder="Mô tả chi tiết về vấn đề hoặc chủ đề bạn muốn thảo luận..."
                                      required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="form-group text-right">
                            <a href="{{ route('discussions.index') }}" class="btn cancel-btn mr-3">
                                <i class="fas fa-times mr-2"></i>Hủy
                            </a>
                            <button type="submit" class="btn submit-btn">
                                <i class="fas fa-paper-plane mr-2"></i>Tạo thảo luận
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Tips -->
            <div class="tips-card">
                <div class="tips-title">
                    <i class="fas fa-lightbulb mr-2"></i>Mẹo tạo thảo luận hiệu quả
                </div>
                <div class="tip-item">
                    <i class="fas fa-check text-success mr-2"></i>
                    Đặt tiêu đề rõ ràng, cụ thể
                </div>
                <div class="tip-item">
                    <i class="fas fa-check text-success mr-2"></i>
                    Chọn đúng danh mục phù hợp
                </div>
                <div class="tip-item">
                    <i class="fas fa-check text-success mr-2"></i>
                    Mô tả chi tiết vấn đề của bạn
                </div>
                <div class="tip-item">
                    <i class="fas fa-check text-success mr-2"></i>
                    Sử dụng ví dụ cụ thể nếu có thể
                </div>
                <div class="tip-item">
                    <i class="fas fa-check text-success mr-2"></i>
                    Tôn trọng và lịch sự với mọi người
                </div>
                <div class="tip-item">
                    <i class="fas fa-check text-success mr-2"></i>
                    Tìm kiếm trước khi tạo thảo luận mới
                </div>
            </div>

            <!-- Recent Discussions -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-clock mr-2"></i>Thảo luận gần đây
                    </h6>
                </div>
                <div class="card-body">
                    <!-- This would be populated with recent discussions -->
                    <p class="text-muted small">Các thảo luận mới nhất sẽ hiển thị ở đây...</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Category selection
    $('.category-option').click(function() {
        $('.category-option').removeClass('selected');
        $(this).addClass('selected');
        $('#discussion_category_id').val($(this).data('category'));
    });

    // Pre-select category if exists
    const selectedCategory = $('#discussion_category_id').val();
    if (selectedCategory) {
        $(`.category-option[data-category="${selectedCategory}"]`).addClass('selected');
    }
});

// Simple text formatting functions
function formatText(command) {
    document.execCommand(command, false, null);
}

function insertList(type) {
    if (type === 'ul') {
        document.execCommand('insertUnorderedList', false, null);
    } else {
        document.execCommand('insertOrderedList', false, null);
    }
}

function insertLink() {
    const url = prompt('Nhập URL:');
    if (url) {
        document.execCommand('createLink', false, url);
    }
}

function insertCode() {
    const code = prompt('Nhập code:');
    if (code) {
        document.execCommand('insertHTML', false, `<code>${code}</code>`);
    }
}
</script>
@endpush
@endsection
