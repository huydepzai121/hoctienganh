@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tạo Danh Mục Mới</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Quay lại
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Thông tin danh mục</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.categories.store') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Tên danh mục sẽ hiển thị trên website</div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Mô tả ngắn về danh mục này</div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Hình ảnh (URL)</label>
                        <input type="url" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" value="{{ old('image') }}">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">URL hình ảnh đại diện cho danh mục</div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Kích hoạt danh mục
                            </label>
                        </div>
                        <div class="form-text">Danh mục sẽ hiển thị trên website khi được kích hoạt</div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Lưu danh mục
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Hướng dẫn</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle me-2"></i>Lưu ý:</h6>
                    <ul class="mb-0">
                        <li>Tên danh mục sẽ tự động tạo slug</li>
                        <li>Slug được sử dụng trong URL</li>
                        <li>Mô tả giúp người dùng hiểu về danh mục</li>
                        <li>Hình ảnh nên có kích thước phù hợp</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
