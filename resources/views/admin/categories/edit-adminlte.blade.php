@extends('layouts.adminlte-pure')

@section('title', 'Chỉnh Sửa Danh Mục - Admin')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Chỉnh Sửa Danh Mục</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Danh Mục</a></li>
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
                    <h3 class="card-title">Thông tin danh mục</h3>
                </div>
                <form method="POST" action="{{ route('admin.categories.update', $category) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Tên danh mục <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $category->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Tên danh mục sẽ hiển thị trên website</small>
                        </div>

                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Mô tả ngắn về danh mục này</small>
                        </div>

                        <div class="form-group">
                            <label for="image">Hình ảnh (URL)</label>
                            <input type="url" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" value="{{ old('image', $category->image) }}">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">URL hình ảnh đại diện cho danh mục</small>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                       {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                                <label for="is_active" class="custom-control-label">Kích hoạt danh mục</label>
                            </div>
                            <small class="form-text text-muted">Danh mục sẽ hiển thị trên website khi được kích hoạt</small>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i>Cập nhật danh mục
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times mr-2"></i>Hủy
                        </a>
                        <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-info">
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
                    <table class="table table-sm">
                        <tr>
                            <td><strong>ID:</strong></td>
                            <td>{{ $category->id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Slug:</strong></td>
                            <td><code>{{ $category->slug }}</code></td>
                        </tr>
                        <tr>
                            <td><strong>Ngày tạo:</strong></td>
                            <td>{{ $category->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Cập nhật:</strong></td>
                            <td>{{ $category->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
