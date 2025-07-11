@extends('layouts.adminlte-pure')

@section('title', 'Chỉnh Sửa Khóa Học - Admin')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Chỉnh Sửa Khóa Học</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">Khóa Học</a></li>
                <li class="breadcrumb-item active">Chỉnh Sửa</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thông tin khóa học</h3>
                </div>
                <form method="POST" action="{{ route('admin.courses.update', $course) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Tiêu đề khóa học <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $course->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Mô tả khóa học <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="5" required>{{ old('description', $course->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category_id">Danh mục <span class="text-danger">*</span></label>
                                    <select class="form-control @error('category_id') is-invalid @enderror" 
                                            id="category_id" name="category_id" required>
                                        <option value="">Chọn danh mục</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                {{ old('category_id', $course->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="level">Cấp độ <span class="text-danger">*</span></label>
                                    <select class="form-control @error('level') is-invalid @enderror" 
                                            id="level" name="level" required>
                                        <option value="">Chọn cấp độ</option>
                                        <option value="beginner" {{ old('level', $course->level) == 'beginner' ? 'selected' : '' }}>Cơ bản</option>
                                        <option value="intermediate" {{ old('level', $course->level) == 'intermediate' ? 'selected' : '' }}>Trung cấp</option>
                                        <option value="advanced" {{ old('level', $course->level) == 'advanced' ? 'selected' : '' }}>Nâng cao</option>
                                    </select>
                                    @error('level')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">Giá (VNĐ) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                           id="price" name="price" value="{{ old('price', $course->price) }}" min="0" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Nhập 0 cho khóa học miễn phí</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="duration">Thời lượng (phút) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('duration') is-invalid @enderror" 
                                           id="duration" name="duration" value="{{ old('duration', $course->duration) }}" min="1" required>
                                    @error('duration')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="image">Hình ảnh (URL)</label>
                            <input type="url" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" value="{{ old('image', $course->image) }}">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="is_published" name="is_published" value="1" 
                                       {{ old('is_published', $course->is_published) ? 'checked' : '' }}>
                                <label for="is_published" class="custom-control-label">Xuất bản khóa học</label>
                            </div>
                            <small class="form-text text-muted">Khóa học sẽ hiển thị trên website khi được xuất bản</small>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i>Cập nhật khóa học
                        </button>
                        <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times mr-2"></i>Hủy
                        </a>
                        <a href="{{ route('admin.courses.show', $course) }}" class="btn btn-info">
                            <i class="fas fa-eye mr-2"></i>Xem chi tiết
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thông tin</h3>
                </div>
                <div class="card-body">
                    @if($course->image)
                        <div class="text-center mb-3">
                            <img src="{{ $course->image }}" alt="{{ $course->title }}" 
                                 class="img-fluid" style="max-height: 150px;">
                        </div>
                    @endif
                    
                    <table class="table table-sm">
                        <tr>
                            <td><strong>ID:</strong></td>
                            <td>{{ $course->id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Slug:</strong></td>
                            <td><code>{{ $course->slug }}</code></td>
                        </tr>
                        <tr>
                            <td><strong>Giảng viên:</strong></td>
                            <td>{{ $course->instructor->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Số bài học:</strong></td>
                            <td>{{ $course->lessons()->count() }}</td>
                        </tr>
                        <tr>
                            <td><strong>Học viên:</strong></td>
                            <td>{{ $course->enrollments()->count() }}</td>
                        </tr>
                        <tr>
                            <td><strong>Ngày tạo:</strong></td>
                            <td>{{ $course->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Cập nhật:</strong></td>
                            <td>{{ $course->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
