@extends('layouts.adminlte-pure')

@section('title', 'Tạo danh mục thảo luận')

@push('styles')
<style>
.form-card {
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

.color-picker-container {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-top: 0.5rem;
}

.color-option {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 3px solid transparent;
    cursor: pointer;
    transition: all 0.3s ease;
}

.color-option:hover {
    transform: scale(1.1);
    border-color: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
}

.color-option.selected {
    border-color: #007bff;
    transform: scale(1.2);
}

.icon-picker-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
    gap: 0.5rem;
    margin-top: 0.5rem;
    max-height: 200px;
    overflow-y: auto;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 1rem;
}

.icon-option {
    width: 50px;
    height: 50px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 1.2rem;
    color: #6c757d;
}

.icon-option:hover {
    border-color: #007bff;
    color: #007bff;
    transform: scale(1.1);
}

.icon-option.selected {
    border-color: #007bff;
    background-color: #007bff;
    color: white;
}

.preview-card {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 1rem;
}

.category-preview {
    display: flex;
    align-items: center;
    padding: 1rem;
    border-radius: 10px;
    background: white;
    border: 2px solid #e9ecef;
}

.preview-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.3rem;
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

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark font-weight-bold">
            <i class="fas fa-plus-circle text-success mr-2"></i>
            Tạo danh mục thảo luận
        </h1>
        <p class="text-muted">Tạo danh mục mới cho hệ thống thảo luận</p>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.discussion-categories.index') }}">Danh mục thảo luận</a></li>
            <li class="breadcrumb-item active">Tạo mới</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="form-card card">
            <div class="card-header bg-white">
                <h4 class="mb-0">
                    <i class="fas fa-folder text-primary mr-2"></i>
                    Thông tin danh mục
                </h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.discussion-categories.store') }}">
                    @csrf
                    
                    <!-- Name -->
                    <div class="form-group">
                        <label for="name">
                            <i class="fas fa-tag mr-1"></i>Tên danh mục *
                        </label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               placeholder="Nhập tên danh mục..."
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description">
                            <i class="fas fa-align-left mr-1"></i>Mô tả (tùy chọn)
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="3" 
                                  placeholder="Mô tả ngắn về danh mục này...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Color Selection -->
                    <div class="form-group">
                        <label>
                            <i class="fas fa-palette mr-1"></i>Màu sắc *
                        </label>
                        <input type="hidden" 
                               name="color" 
                               id="color" 
                               value="{{ old('color', '#007bff') }}"
                               class="@error('color') is-invalid @enderror">
                        <div class="color-picker-container">
                            <div class="color-option selected" data-color="#007bff" style="background-color: #007bff;" title="Xanh dương"></div>
                            <div class="color-option" data-color="#28a745" style="background-color: #28a745;" title="Xanh lá"></div>
                            <div class="color-option" data-color="#ffc107" style="background-color: #ffc107;" title="Vàng"></div>
                            <div class="color-option" data-color="#dc3545" style="background-color: #dc3545;" title="Đỏ"></div>
                            <div class="color-option" data-color="#6f42c1" style="background-color: #6f42c1;" title="Tím"></div>
                            <div class="color-option" data-color="#17a2b8" style="background-color: #17a2b8;" title="Xanh ngọc"></div>
                            <div class="color-option" data-color="#fd7e14" style="background-color: #fd7e14;" title="Cam"></div>
                            <div class="color-option" data-color="#20c997" style="background-color: #20c997;" title="Xanh mint"></div>
                            <div class="color-option" data-color="#6c757d" style="background-color: #6c757d;" title="Xám"></div>
                            <div class="color-option" data-color="#343a40" style="background-color: #343a40;" title="Đen"></div>
                        </div>
                        @error('color')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Icon Selection -->
                    <div class="form-group">
                        <label>
                            <i class="fas fa-icons mr-1"></i>Biểu tượng (tùy chọn)
                        </label>
                        <input type="hidden" name="icon" id="icon" value="{{ old('icon') }}">
                        <div class="icon-picker-container">
                            <div class="icon-option" data-icon="fas fa-question-circle" title="Hỏi đáp">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            <div class="icon-option" data-icon="fas fa-book" title="Sách">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="icon-option" data-icon="fas fa-spell-check" title="Từ vựng">
                                <i class="fas fa-spell-check"></i>
                            </div>
                            <div class="icon-option" data-icon="fas fa-microphone" title="Phát âm">
                                <i class="fas fa-microphone"></i>
                            </div>
                            <div class="icon-option" data-icon="fas fa-graduation-cap" title="Thi cử">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div class="icon-option" data-icon="fas fa-comments" title="Giao tiếp">
                                <i class="fas fa-comments"></i>
                            </div>
                            <div class="icon-option" data-icon="fas fa-file-alt" title="Tài liệu">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="icon-option" data-icon="fas fa-lightbulb" title="Ý tưởng">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                            <div class="icon-option" data-icon="fas fa-users" title="Cộng đồng">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="icon-option" data-icon="fas fa-star" title="Nổi bật">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="icon-option" data-icon="fas fa-heart" title="Yêu thích">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div class="icon-option" data-icon="fas fa-globe" title="Quốc tế">
                                <i class="fas fa-globe"></i>
                            </div>
                            <div class="icon-option" data-icon="fas fa-music" title="Âm nhạc">
                                <i class="fas fa-music"></i>
                            </div>
                            <div class="icon-option" data-icon="fas fa-film" title="Phim ảnh">
                                <i class="fas fa-film"></i>
                            </div>
                            <div class="icon-option" data-icon="fas fa-gamepad" title="Trò chơi">
                                <i class="fas fa-gamepad"></i>
                            </div>
                            <div class="icon-option" data-icon="fas fa-briefcase" title="Công việc">
                                <i class="fas fa-briefcase"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Sort Order -->
                    <div class="form-group">
                        <label for="sort_order">
                            <i class="fas fa-sort-numeric-up mr-1"></i>Thứ tự sắp xếp
                        </label>
                        <input type="number" 
                               class="form-control @error('sort_order') is-invalid @enderror" 
                               id="sort_order" 
                               name="sort_order" 
                               value="{{ old('sort_order', 0) }}" 
                               min="0"
                               placeholder="0">
                        <small class="form-text text-muted">Số nhỏ hơn sẽ hiển thị trước</small>
                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" 
                                   class="custom-control-input" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1" 
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_active">
                                <i class="fas fa-toggle-on mr-1"></i>Kích hoạt danh mục
                            </label>
                        </div>
                        <small class="form-text text-muted">Danh mục sẽ hiển thị công khai khi được kích hoạt</small>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="form-group text-right">
                        <a href="{{ route('admin.discussion-categories.index') }}" class="btn cancel-btn mr-3">
                            <i class="fas fa-times mr-2"></i>Hủy
                        </a>
                        <button type="submit" class="btn submit-btn">
                            <i class="fas fa-save mr-2"></i>Tạo danh mục
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Preview -->
        <div class="preview-card">
            <h5 class="font-weight-bold mb-3">
                <i class="fas fa-eye mr-2"></i>Xem trước
            </h5>
            <div class="category-preview" id="category-preview">
                <div class="preview-icon" id="preview-icon" style="background-color: #007bff;">
                    <i class="fas fa-folder"></i>
                </div>
                <div>
                    <div class="font-weight-bold" id="preview-name">Tên danh mục</div>
                    <small class="text-muted" id="preview-description">Mô tả danh mục sẽ hiển thị ở đây</small>
                </div>
            </div>
        </div>

        <!-- Tips -->
        <div class="tips-card">
            <div class="tips-title">
                <i class="fas fa-lightbulb mr-2"></i>Mẹo tạo danh mục hiệu quả
            </div>
            <div class="tip-item">
                <i class="fas fa-check text-success mr-2"></i>
                Đặt tên ngắn gọn, dễ hiểu
            </div>
            <div class="tip-item">
                <i class="fas fa-check text-success mr-2"></i>
                Chọn màu sắc phù hợp với chủ đề
            </div>
            <div class="tip-item">
                <i class="fas fa-check text-success mr-2"></i>
                Sử dụng biểu tượng trực quan
            </div>
            <div class="tip-item">
                <i class="fas fa-check text-success mr-2"></i>
                Viết mô tả rõ ràng về mục đích
            </div>
            <div class="tip-item">
                <i class="fas fa-check text-success mr-2"></i>
                Sắp xếp thứ tự hợp lý
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Color picker
    $('.color-option').click(function() {
        $('.color-option').removeClass('selected');
        $(this).addClass('selected');
        const color = $(this).data('color');
        $('#color').val(color);
        $('#preview-icon').css('background-color', color);
    });

    // Icon picker
    $('.icon-option').click(function() {
        $('.icon-option').removeClass('selected');
        $(this).addClass('selected');
        const icon = $(this).data('icon');
        $('#icon').val(icon);
        $('#preview-icon i').attr('class', icon);
    });

    // Live preview
    $('#name').on('input', function() {
        const name = $(this).val() || 'Tên danh mục';
        $('#preview-name').text(name);
    });

    $('#description').on('input', function() {
        const description = $(this).val() || 'Mô tả danh mục sẽ hiển thị ở đây';
        $('#preview-description').text(description);
    });

    // Pre-select old values if any
    const oldIcon = '{{ old("icon") }}';
    if (oldIcon) {
        $(`.icon-option[data-icon="${oldIcon}"]`).click();
    }

    const oldColor = '{{ old("color", "#007bff") }}';
    $(`.color-option[data-color="${oldColor}"]`).click();
});
</script>
@endpush
@endsection
