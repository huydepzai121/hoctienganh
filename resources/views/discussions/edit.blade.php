@extends('layouts.app')

@section('title', 'Chỉnh sửa thảo luận')

@push('styles')
<style>
.edit-form-card {
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
    transform: scale(1.02);
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
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
    background: linear-gradient(135deg, #007bff, #0056b3);
    border: none;
    border-radius: 25px;
    padding: 0.75rem 2rem;
    color: white;
    font-weight: 600;
    transition: all 0.3s ease;
}

.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
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

/* CKEditor Custom Styles */
.ck-editor__editable {
    min-height: 300px;
    border-radius: 8px;
}

.ck-editor__editable:focus {
    border-color: #007bff !important;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
}

.ck.ck-toolbar {
    border-radius: 8px 8px 0 0;
    border-color: #e9ecef;
}

.ck.ck-editor__main > .ck-editor__editable {
    border-radius: 0 0 8px 8px;
    border-color: #e9ecef;
}

.ck.ck-content {
    font-family: inherit;
    font-size: 14px;
    line-height: 1.6;
}
</style>
@endpush

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <div class="edit-form-card card">
                <div class="card-header bg-white">
                    <h4 class="mb-0">
                        <i class="fas fa-edit text-primary mr-2"></i>
                        Chỉnh sửa thảo luận
                    </h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('discussions.update', $discussion->slug) }}">
                        @csrf
                        @method('PATCH')
                        
                        <!-- Title -->
                        <div class="form-group">
                            <label for="title">
                                <i class="fas fa-heading mr-1"></i>Tiêu đề thảo luận *
                            </label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $discussion->title) }}" 
                                   placeholder="Nhập tiêu đề thảo luận của bạn..."
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Category Selection -->
                        <div class="form-group">
                            <label for="discussion_category_id">
                                <i class="fas fa-folder mr-1"></i>Chọn danh mục *
                            </label>
                            <select class="form-control @error('discussion_category_id') is-invalid @enderror"
                                    id="discussion_category_id"
                                    name="discussion_category_id"
                                    required>
                                <option value="">-- Chọn danh mục thảo luận --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                            {{ old('discussion_category_id', $discussion->discussion_category_id) == $category->id ? 'selected' : '' }}
                                            data-color="{{ $category->color }}"
                                            data-icon="{{ $category->icon }}">
                                        {{ $category->name }} - {{ $category->description }}
                                    </option>
                                @endforeach
                            </select>
                            @error('discussion_category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
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
                                            {{ old('course_id', $discussion->course_id) == $course->id ? 'selected' : '' }}>
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
                            <textarea class="form-control @error('content') is-invalid @enderror"
                                      id="content"
                                      name="content"
                                      rows="8"
                                      style="display: none;"
                                      required>{{ old('content', $discussion->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="form-group text-right">
                            <a href="{{ route('discussions.show', $discussion->slug) }}" class="btn cancel-btn mr-3">
                                <i class="fas fa-times mr-2"></i>Hủy
                            </a>
                            <button type="submit" class="btn submit-btn">
                                <i class="fas fa-save mr-2"></i>Cập nhật thảo luận
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Discussion Info -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle mr-2"></i>Thông tin thảo luận
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <strong>Tạo bởi:</strong> {{ $discussion->user->name }}
                    </div>
                    <div class="mb-2">
                        <strong>Ngày tạo:</strong> {{ $discussion->created_at->format('d/m/Y H:i') }}
                    </div>
                    <div class="mb-2">
                        <strong>Lượt xem:</strong> {{ number_format($discussion->views_count) }}
                    </div>
                    <div class="mb-2">
                        <strong>Trả lời:</strong> {{ $discussion->replies_count }}
                    </div>
                    <div class="mb-2">
                        <strong>Votes:</strong> {{ $discussion->votes_count }}
                    </div>
                    <div>
                        <strong>Trạng thái:</strong> 
                        @if($discussion->status === 'open')
                            <span class="badge badge-success">Đang mở</span>
                        @elseif($discussion->status === 'solved')
                            <span class="badge badge-info">Đã giải quyết</span>
                        @else
                            <span class="badge badge-secondary">Đã đóng</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- jQuery (nếu chưa có) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- CKEditor CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
let editor;

document.addEventListener('DOMContentLoaded', function() {
    // Initialize CKEditor
    ClassicEditor
        .create(document.querySelector('#content'), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'underline', '|',
                    'bulletedList', 'numberedList', '|',
                    'outdent', 'indent', '|',
                    'link', 'blockQuote', '|',
                    'code', 'codeBlock', '|',
                    'undo', 'redo'
                ]
            },
            placeholder: 'Mô tả chi tiết về vấn đề hoặc chủ đề bạn muốn thảo luận...',
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
                ]
            }
        })
        .then(newEditor => {
            editor = newEditor;

            // Set initial content
            const initialContent = `{!! addslashes($discussion->content) !!}`;
            if (initialContent) {
                editor.setData(initialContent);
            }

            // Update textarea when editor content changes
            editor.model.document.on('change:data', () => {
                document.querySelector('#content').value = editor.getData();
            });
        })
        .catch(error => {
            console.error('CKEditor initialization error:', error);
            // Fallback to regular textarea if CKEditor fails
            document.querySelector('#content').style.display = 'block';
        });

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        // Update textarea with CKEditor content before validation
        if (editor) {
            document.querySelector('#content').value = editor.getData();
        }

        const categorySelected = document.getElementById('discussion_category_id').value;
        const content = document.querySelector('#content').value.trim();

        if (!categorySelected) {
            e.preventDefault();
            alert('Vui lòng chọn danh mục thảo luận');
            document.getElementById('discussion_category_id').focus();
            return false;
        }

        if (!content) {
            e.preventDefault();
            alert('Vui lòng nhập nội dung thảo luận');
            return false;
        }
    });
});

</script>
@endpush
@endsection
