@extends('layouts.adminlte-pure')

@section('title', 'Chi Tiết Danh Mục - Admin')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Chi Tiết Danh Mục</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Danh Mục</a></li>
                <li class="breadcrumb-item active">Chi Tiết</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $category->name }}</h3>
                    <div class="card-tools">
                        @if($category->is_active)
                            <span class="badge badge-success">Hoạt động</span>
                        @else
                            <span class="badge badge-secondary">Tạm dừng</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if($category->image)
                        <div class="text-center mb-3">
                            <img src="{{ $category->image }}" alt="{{ $category->name }}" 
                                 class="img-fluid" style="max-height: 200px;">
                        </div>
                    @endif

                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 200px;">ID</th>
                            <td>{{ $category->id }}</td>
                        </tr>
                        <tr>
                            <th>Tên danh mục</th>
                            <td>{{ $category->name }}</td>
                        </tr>
                        <tr>
                            <th>Slug</th>
                            <td><code>{{ $category->slug }}</code></td>
                        </tr>
                        <tr>
                            <th>Mô tả</th>
                            <td>{{ $category->description ?: 'Không có mô tả' }}</td>
                        </tr>
                        <tr>
                            <th>Hình ảnh</th>
                            <td>
                                @if($category->image)
                                    <a href="{{ $category->image }}" target="_blank">{{ $category->image }}</a>
                                @else
                                    Không có hình ảnh
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Trạng thái</th>
                            <td>
                                @if($category->is_active)
                                    <span class="badge badge-success">Hoạt động</span>
                                @else
                                    <span class="badge badge-secondary">Tạm dừng</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Ngày tạo</th>
                            <td>{{ $category->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Cập nhật lần cuối</th>
                            <td>{{ $category->updated_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
                
                <div class="card-footer">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">
                        <i class="fas fa-edit mr-2"></i>Chỉnh sửa
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                        <i class="fas fa-list mr-2"></i>Danh sách
                    </a>
                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-delete">
                            <i class="fas fa-trash mr-2"></i>Xóa
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Khóa học trong danh mục</h3>
                </div>
                <div class="card-body">
                    @php
                        $courses = $category->courses()->take(10)->get();
                    @endphp
                    
                    @if($courses->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($courses as $course)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ Str::limit($course->title, 30) }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            {{ $course->price > 0 ? number_format($course->price) . 'đ' : 'Miễn phí' }}
                                        </small>
                                    </div>
                                    <div>
                                        @if($course->is_published)
                                            <span class="badge badge-success">Đã xuất bản</span>
                                        @else
                                            <span class="badge badge-warning">Nháp</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @if($category->courses()->count() > 10)
                            <div class="text-center mt-3">
                                <a href="{{ route('admin.courses.index', ['category' => $category->id]) }}" class="btn btn-sm btn-outline-primary">
                                    Xem tất cả ({{ $category->courses()->count() }})
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center text-muted">
                            <i class="fas fa-book fa-3x mb-3"></i>
                            <p>Chưa có khóa học nào trong danh mục này</p>
                            <a href="{{ route('admin.courses.create') }}" class="btn btn-sm btn-primary">
                                Tạo khóa học mới
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
