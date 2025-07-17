@extends('layouts.app')

@section('title', 'Tạo thảo luận mới')

@push('styles')
<style>
/* Modern Bootstrap 5 Design */
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 3rem 0;
    margin-bottom: 3rem;
}

.discussion-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    border: none;
    overflow: hidden;
    margin-bottom: 2rem;
}

.form-floating > .form-control {
    border: 2px solid #e9ecef;
    border-radius: 15px;
    transition: all 0.3s ease;
    font-size: 1rem;
}

.form-floating > .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.15);
}

.form-floating > label {
    color: #6c757d;
    font-weight: 500;
}

.form-select {
    border: 2px solid #e9ecef;
    border-radius: 15px;
    padding: 1rem;
    transition: all 0.3s ease;
    background-color: #f8f9fa;
}

.form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.15);
    background-color: white;
}

.category-preview {
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    border: 2px solid #667eea;
    border-radius: 15px;
    padding: 1.5rem;
    margin-top: 1rem;
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

.category-icon {
    width: 50px;
    height: 50px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.3rem;
    margin-right: 1rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.btn-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 25px;
    padding: 0.75rem 2rem;
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.btn-gradient:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
    color: white;
}

.btn-outline-custom {
    border: 2px solid #6c757d;
    border-radius: 25px;
    padding: 0.75rem 2rem;
    color: #6c757d;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background: transparent;
    transition: all 0.3s ease;
}

.btn-outline-custom:hover {
    background: #6c757d;
    color: white;
    transform: translateY(-3px);
}

.tips-card {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
    border-radius: 20px;
    padding: 2rem;
    border: none;
}

.tip-item {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
    padding: 0.75rem;
    background: rgba(255,255,255,0.15);
    border-radius: 12px;
    backdrop-filter: blur(10px);
}

.tip-item i {
    margin-right: 0.75rem;
    font-size: 1.1rem;
}

/* CKEditor Large Size Styling */
.ck-editor {
    border-radius: 20px;
    overflow: hidden;
    border: 3px solid #e9ecef;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.ck-editor:focus-within {
    border-color: #667eea;
    box-shadow: 0 0 0 0.3rem rgba(102, 126, 234, 0.2), 0 15px 35px rgba(0,0,0,0.15);
    transform: translateY(-2px);
}

.ck-editor__editable {
    min-height: 500px !important;
    padding: 2rem !important;
    font-size: 1.1rem !important;
    line-height: 1.8 !important;
    background: #fafbfc;
}

.ck-toolbar {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 2px solid #dee2e6;
    padding: 1.5rem !important;
    border-radius: 20px 20px 0 0;
}

.ck-toolbar .ck-toolbar__items {
    flex-wrap: wrap;
    gap: 0.5rem;
}

.ck-button {
    border-radius: 8px !important;
    padding: 0.5rem 0.75rem !important;
    transition: all 0.2s ease !important;
}

.ck-button:hover {
    background: #667eea !important;
    color: white !important;
    transform: translateY(-1px);
}

.ck-button.ck-on {
    background: #667eea !important;
    color: white !important;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
}

.ck-dropdown__button {
    border-radius: 8px !important;
    padding: 0.5rem 1rem !important;
}

/* Content styling inside editor */
.ck-content h1 {
    font-size: 2rem !important;
    font-weight: 700 !important;
    color: #2c3e50 !important;
    margin-bottom: 1rem !important;
}

.ck-content h2 {
    font-size: 1.6rem !important;
    font-weight: 600 !important;
    color: #34495e !important;
    margin-bottom: 0.8rem !important;
}

.ck-content h3 {
    font-size: 1.3rem !important;
    font-weight: 600 !important;
    color: #34495e !important;
    margin-bottom: 0.6rem !important;
}

.ck-content p {
    margin-bottom: 1rem !important;
    color: #2c3e50 !important;
}

.ck-content blockquote {
    border-left: 4px solid #667eea !important;
    padding-left: 1.5rem !important;
    margin: 1.5rem 0 !important;
    font-style: italic !important;
    background: #f8f9fa !important;
    padding: 1.5rem !important;
    border-radius: 8px !important;
}

.ck-content code {
    background: #f1f3f4 !important;
    padding: 0.3rem 0.6rem !important;
    border-radius: 6px !important;
    font-family: 'Courier New', monospace !important;
    color: #e83e8c !important;
    font-size: 0.9rem !important;
}

.ck-content pre {
    background: #2d3748 !important;
    color: #e2e8f0 !important;
    padding: 1.5rem !important;
    border-radius: 12px !important;
    border-left: 4px solid #667eea !important;
    overflow-x: auto !important;
    margin: 1.5rem 0 !important;
}

.ck-content pre code {
    background: none !important;
    color: #e2e8f0 !important;
    padding: 0 !important;
}

.ck-content ul, .ck-content ol {
    padding-left: 2rem !important;
    margin-bottom: 1rem !important;
}

.ck-content li {
    margin-bottom: 0.5rem !important;
    line-height: 1.6 !important;
}

/* Editor container styling */
.editor-container {
    background: white;
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
    transition: all 0.3s ease;
}

.editor-container.fullscreen {
    border-radius: 0;
    box-shadow: none;
}

.editor-tools {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.editor-tools .btn {
    border-radius: 20px;
    font-size: 0.85rem;
    transition: all 0.2s ease;
}

.editor-tools .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* Responsive editor */
@media (max-width: 768px) {
    .ck-editor__editable {
        min-height: 400px !important;
        padding: 1rem !important;
        font-size: 1rem !important;
    }

    .ck-toolbar {
        padding: 1rem !important;
    }

    .editor-container {
        padding: 1rem;
    }

    .editor-tools {
        flex-direction: column;
        align-items: flex-end;
        gap: 0.25rem;
    }

    .editor-tools .btn {
        font-size: 0.8rem;
        padding: 0.25rem 0.5rem;
    }
}

@media (max-width: 768px) {
    .hero-section {
        padding: 2rem 0;
    }
    
    .btn-gradient, .btn-outline-custom {
        width: 100%;
        margin-bottom: 0.5rem;
    }
}
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h1 class="display-5 fw-bold mb-3">
                    <i class="fas fa-plus-circle me-3"></i>
                    Tạo thảo luận mới
                </h1>
                <p class="lead mb-0">
                    Chia sẻ câu hỏi, kinh nghiệm và kết nối với cộng đồng học tiếng Anh
                </p>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <!-- Main Form -->
        <div class="col-lg-8">
            <div class="discussion-card">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('discussions.store') }}">
                        @csrf
                        
                        <!-- Title -->
                        <div class="form-floating mb-4">
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}" 
                                   placeholder="Nhập tiêu đề thảo luận..."
                                   required>
                            <label for="title">
                                <i class="fas fa-heading me-2"></i>Tiêu đề thảo luận
                            </label>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Category Selection -->
                        <div class="mb-4">
                            <label for="discussion_category_id" class="form-label fw-bold">
                                <i class="fas fa-folder me-2"></i>Chọn danh mục
                            </label>
                            <select class="form-select @error('discussion_category_id') is-invalid @enderror" 
                                    id="discussion_category_id" 
                                    name="discussion_category_id" 
                                    required>
                                <option value="">🎯 Chọn danh mục phù hợp cho thảo luận của bạn</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('discussion_category_id') == $category->id ? 'selected' : '' }}
                                            data-color="{{ $category->color }}"
                                            data-icon="{{ $category->icon }}"
                                            data-description="{{ $category->description }}">
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('discussion_category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <!-- Category Preview -->
                            <div id="category-preview" class="category-preview" style="display: none;">
                                <div class="d-flex align-items-center">
                                    <div id="preview-icon" class="category-icon">
                                        <i class="fas fa-folder"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold" id="preview-name">Danh mục đã chọn</h6>
                                        <small class="text-muted" id="preview-desc">Mô tả danh mục</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Course Selection -->
                        <div class="form-floating mb-4">
                            <select class="form-select @error('course_id') is-invalid @enderror" 
                                    id="course_id" 
                                    name="course_id">
                                <option value="">Không liên quan đến khóa học cụ thể</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" 
                                            {{ old('course_id', $selectedCourse) == $course->id ? 'selected' : '' }}>
                                        {{ $course->title }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="course_id">
                                <i class="fas fa-book me-2"></i>Khóa học liên quan (tùy chọn)
                            </label>
                            @error('course_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Content Editor -->
                        <div class="mb-4">
                            <label for="content" class="form-label fw-bold mb-3">
                                <i class="fas fa-edit me-2"></i>Nội dung thảo luận
                                <span class="badge bg-primary ms-2">Rich Text Editor</span>
                            </label>
                            <div class="editor-container">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Sử dụng toolbar để định dạng văn bản, thêm liên kết, code blocks...
                                    </small>
                                    <div class="editor-tools">
                                        <button type="button" class="btn btn-sm btn-outline-secondary me-2" onclick="toggleFullscreen()">
                                            <i class="fas fa-expand"></i> Toàn màn hình
                                        </button>
                                        <span class="badge bg-light text-dark" id="word-count">0 từ</span>
                                    </div>
                                </div>
                                <textarea class="form-control @error('content') is-invalid @enderror"
                                          id="content"
                                          name="content"
                                          rows="8"
                                          style="display: none;"
                                          required>{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex gap-3 justify-content-end">
                            <a href="{{ route('discussions.index') }}" class="btn btn-outline-custom">
                                <i class="fas fa-times me-2"></i>Hủy bỏ
                            </a>
                            <button type="submit" class="btn btn-gradient">
                                <i class="fas fa-paper-plane me-2"></i>Tạo thảo luận
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Tips Card -->
            <div class="tips-card">
                <h5 class="fw-bold mb-4">
                    <i class="fas fa-lightbulb me-2"></i>
                    Mẹo tạo thảo luận hiệu quả
                </h5>
                
                <div class="tip-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Đặt tiêu đề rõ ràng, cụ thể</span>
                </div>
                
                <div class="tip-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Chọn đúng danh mục phù hợp</span>
                </div>
                
                <div class="tip-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Mô tả chi tiết vấn đề của bạn</span>
                </div>
                
                <div class="tip-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Sử dụng ví dụ cụ thể nếu có thể</span>
                </div>
                
                <div class="tip-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Tôn trọng và lịch sự với mọi người</span>
                </div>
                
                <div class="tip-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Tìm kiếm trước khi tạo thảo luận mới</span>
                </div>
            </div>

            <!-- Recent Discussions -->
            <div class="discussion-card">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-clock me-2 text-primary"></i>
                        Thảo luận gần đây
                    </h6>
                    <p class="text-muted small mb-0">
                        Các thảo luận mới nhất từ cộng đồng sẽ hiển thị ở đây...
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- CKEditor CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
let editor;

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Large CKEditor
    ClassicEditor
        .create(document.querySelector('#content'), {
            toolbar: {
                items: [
                    'heading', '|',
                    'fontSize', 'fontColor', 'fontBackgroundColor', '|',
                    'bold', 'italic', 'underline', 'strikethrough', '|',
                    'bulletedList', 'numberedList', 'todoList', '|',
                    'outdent', 'indent', 'alignment', '|',
                    'link', 'blockQuote', 'insertTable', '|',
                    'code', 'codeBlock', 'horizontalLine', '|',
                    'imageUpload', 'mediaEmbed', '|',
                    'undo', 'redo', '|',
                    'findAndReplace', 'selectAll'
                ],
                shouldNotGroupWhenFull: true
            },
            placeholder: '✍️ Bắt đầu viết nội dung thảo luận của bạn...\n\n💡 Mẹo:\n• Sử dụng tiêu đề để tổ chức nội dung\n• Thêm code blocks cho ví dụ lập trình\n• Sử dụng danh sách để liệt kê các điểm quan trọng\n• Thêm liên kết tham khảo nếu có',
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Tiêu đề chính', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Tiêu đề phụ', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Tiêu đề nhỏ', class: 'ck-heading_heading3' }
                ]
            },
            fontSize: {
                options: [
                    'tiny', 'small', 'default', 'big', 'huge'
                ]
            },
            fontColor: {
                colors: [
                    { color: '#000000', label: 'Đen' },
                    { color: '#667eea', label: 'Xanh chủ đạo' },
                    { color: '#e74c3c', label: 'Đỏ' },
                    { color: '#27ae60', label: 'Xanh lá' },
                    { color: '#f39c12', label: 'Cam' },
                    { color: '#9b59b6', label: 'Tím' }
                ]
            },
            table: {
                contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
            },
            image: {
                toolbar: ['imageTextAlternative', 'imageStyle:full', 'imageStyle:side']
            }
        })
        .then(newEditor => {
            editor = newEditor;

            // Set initial content if exists
            const initialContent = `{{ old('content') }}`;
            if (initialContent) {
                editor.setData(initialContent);
            }

            // Update textarea when editor content changes
            editor.model.document.on('change:data', () => {
                document.querySelector('#content').value = editor.getData();
                updateWordCount();
            });

            // Initial word count
            updateWordCount();

            // Auto-resize editor
            editor.editing.view.change(writer => {
                writer.setStyle('min-height', '500px', editor.editing.view.document.getRoot());
            });
        })
        .catch(error => {
            console.error('CKEditor initialization error:', error);
            // Fallback to regular textarea if CKEditor fails
            const textarea = document.querySelector('#content');
            textarea.style.display = 'block';
            textarea.style.minHeight = '500px';
            textarea.style.fontSize = '1.1rem';
            textarea.style.padding = '2rem';
            textarea.style.borderRadius = '15px';
            textarea.style.border = '2px solid #e9ecef';
        });

    // Category selection handler
    const categorySelect = document.getElementById('discussion_category_id');
    const categoryPreview = document.getElementById('category-preview');
    const previewIcon = document.getElementById('preview-icon');
    const previewName = document.getElementById('preview-name');
    const previewDesc = document.getElementById('preview-desc');

    categorySelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];

        if (this.value) {
            const color = selectedOption.getAttribute('data-color') || '#667eea';
            const icon = selectedOption.getAttribute('data-icon') || 'fas fa-folder';
            const name = selectedOption.text;
            const desc = selectedOption.getAttribute('data-description') || '';

            previewIcon.style.backgroundColor = color;
            previewIcon.innerHTML = `<i class="${icon}"></i>`;
            previewName.textContent = name;
            previewDesc.textContent = desc;

            categoryPreview.style.display = 'block';
        } else {
            categoryPreview.style.display = 'none';
        }
    });

    // Form validation with better UX
    document.querySelector('form').addEventListener('submit', function(e) {
        // Update textarea with CKEditor content before validation
        if (editor) {
            document.querySelector('#content').value = editor.getData();
        }

        const title = document.getElementById('title').value.trim();
        const categorySelected = document.getElementById('discussion_category_id').value;
        const content = document.querySelector('#content').value.trim();

        // Validation with user-friendly messages
        if (!title) {
            e.preventDefault();
            showAlert('Vui lòng nhập tiêu đề thảo luận', 'warning');
            document.getElementById('title').focus();
            return false;
        }

        if (!categorySelected) {
            e.preventDefault();
            showAlert('Vui lòng chọn danh mục thảo luận', 'warning');
            document.getElementById('discussion_category_id').focus();
            return false;
        }

        if (!content || content.length < 10) {
            e.preventDefault();
            showAlert('Vui lòng nhập nội dung thảo luận (ít nhất 10 ký tự)', 'warning');
            return false;
        }

        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang tạo...';
        submitBtn.disabled = true;

        // Re-enable button after 5 seconds as fallback
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 5000);
    });

    // Auto-save draft functionality (optional)
    let autoSaveTimer;
    function autoSaveDraft() {
        if (editor) {
            const title = document.getElementById('title').value;
            const category = document.getElementById('discussion_category_id').value;
            const content = editor.getData();

            if (title || content) {
                localStorage.setItem('discussion_draft', JSON.stringify({
                    title: title,
                    category: category,
                    content: content,
                    timestamp: Date.now()
                }));
            }
        }
    }

    // Auto-save every 30 seconds
    document.getElementById('title').addEventListener('input', () => {
        clearTimeout(autoSaveTimer);
        autoSaveTimer = setTimeout(autoSaveDraft, 30000);
    });

    // Load draft if exists
    const savedDraft = localStorage.getItem('discussion_draft');
    if (savedDraft) {
        const draft = JSON.parse(savedDraft);
        const timeDiff = Date.now() - draft.timestamp;

        // Only load draft if it's less than 24 hours old
        if (timeDiff < 24 * 60 * 60 * 1000) {
            if (confirm('Bạn có muốn khôi phục bản nháp đã lưu không?')) {
                document.getElementById('title').value = draft.title;
                document.getElementById('discussion_category_id').value = draft.category;
                if (editor && draft.content) {
                    editor.setData(draft.content);
                }

                // Trigger category preview
                categorySelect.dispatchEvent(new Event('change'));
            }
        }
    }
});

// Helper function for alerts
function showAlert(message, type = 'info') {
    // Create Bootstrap alert
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(alertDiv);

    // Auto remove after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}

// Word count function
function updateWordCount() {
    if (editor) {
        const content = editor.getData();
        const textContent = content.replace(/<[^>]*>/g, ''); // Remove HTML tags
        const wordCount = textContent.trim().split(/\s+/).filter(word => word.length > 0).length;
        const charCount = textContent.length;

        document.getElementById('word-count').innerHTML = `
            <i class="fas fa-file-alt me-1"></i>
            ${wordCount} từ, ${charCount} ký tự
        `;

        // Change color based on content length
        const wordCountElement = document.getElementById('word-count');
        if (wordCount < 10) {
            wordCountElement.className = 'badge bg-warning text-dark';
        } else if (wordCount < 50) {
            wordCountElement.className = 'badge bg-info text-dark';
        } else {
            wordCountElement.className = 'badge bg-success';
        }
    }
}

// Fullscreen toggle function
function toggleFullscreen() {
    const editorContainer = document.querySelector('.editor-container');
    const button = event.target.closest('button');

    if (!editorContainer.classList.contains('fullscreen')) {
        // Enter fullscreen
        editorContainer.classList.add('fullscreen');
        editorContainer.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 9999;
            background: white;
            padding: 2rem;
            overflow-y: auto;
        `;

        button.innerHTML = '<i class="fas fa-compress"></i> Thoát toàn màn hình';

        // Resize editor
        if (editor) {
            editor.editing.view.change(writer => {
                writer.setStyle('min-height', 'calc(100vh - 200px)', editor.editing.view.document.getRoot());
            });
        }
    } else {
        // Exit fullscreen
        editorContainer.classList.remove('fullscreen');
        editorContainer.style.cssText = '';

        button.innerHTML = '<i class="fas fa-expand"></i> Toàn màn hình';

        // Reset editor size
        if (editor) {
            editor.editing.view.change(writer => {
                writer.setStyle('min-height', '500px', editor.editing.view.document.getRoot());
            });
        }
    }
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + S to save draft
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        autoSaveDraft();
        showAlert('Đã lưu bản nháp!', 'success');
    }

    // F11 to toggle fullscreen
    if (e.key === 'F11') {
        e.preventDefault();
        toggleFullscreen();
    }

    // Escape to exit fullscreen
    if (e.key === 'Escape') {
        const editorContainer = document.querySelector('.editor-container');
        if (editorContainer.classList.contains('fullscreen')) {
            toggleFullscreen();
        }
    }
});
</script>
@endpush
