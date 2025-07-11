@extends('layouts.adminlte-pure')

@section('title', 'Quản Lý Khóa Học - Admin')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Quản Lý Khóa Học</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Khóa Học</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh Sách Khóa Học</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-2"></i>Thêm Khóa Học
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($courses->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">ID</th>
                                        <th>Hình ảnh</th>
                                        <th>Tiêu đề</th>
                                        <th>Danh mục</th>
                                        <th>Giảng viên</th>
                                        <th>Giá</th>
                                        <th>Cấp độ</th>
                                        <th style="width: 100px">Trạng thái</th>
                                        <th style="width: 150px">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($courses as $course)
                                    <tr>
                                        <td>{{ $course->id }}</td>
                                        <td>
                                            <img src="{{ $course->image ?? 'https://via.placeholder.com/50x50/007bff/ffffff?text=C' }}" 
                                                 class="img-thumbnail" width="50" height="50" style="object-fit: cover;" alt="{{ $course->title }}">
                                        </td>
                                        <td>
                                            <div class="font-weight-bold">{{ Str::limit($course->title, 40) }}</div>
                                            <small class="text-muted">{{ $course->duration }} phút</small>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ $course->category->name }}</span>
                                        </td>
                                        <td>{{ $course->instructor->name ?? 'N/A' }}</td>
                                        <td>
                                            @if($course->price > 0)
                                                <span class="text-success font-weight-bold">{{ number_format($course->price) }}đ</span>
                                            @else
                                                <span class="badge badge-success">Miễn phí</span>
                                            @endif
                                        </td>
                                        <td>
                                            @switch($course->level)
                                                @case('beginner')
                                                    <span class="badge badge-success">Cơ bản</span>
                                                    @break
                                                @case('intermediate')
                                                    <span class="badge badge-warning">Trung cấp</span>
                                                    @break
                                                @case('advanced')
                                                    <span class="badge badge-danger">Nâng cao</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>
                                            @if($course->is_published)
                                                <span class="badge badge-success">Đã xuất bản</span>
                                            @else
                                                <span class="badge badge-secondary">Nháp</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.courses.show', $course) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('admin.courses.destroy', $course) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger btn-delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $courses->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-book fa-5x text-muted mb-4"></i>
                            <h4>Chưa có khóa học nào</h4>
                            <p class="text-muted">Hãy tạo khóa học đầu tiên cho website của bạn</p>
                            <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus mr-2"></i>Tạo Khóa Học Đầu Tiên
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
