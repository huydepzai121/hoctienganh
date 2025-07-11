@extends('layouts.adminlte-pure')

@section('title', 'Quản Lý Bài Học - Admin')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Quản Lý Bài Học</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Bài Học</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh Sách Bài Học</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.lessons.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-2"></i>Thêm Bài Học
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($lessons->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">ID</th>
                                        <th>Tiêu đề</th>
                                        <th>Khóa học</th>
                                        <th>Thứ tự</th>
                                        <th>Thời lượng</th>
                                        <th>Video</th>
                                        <th style="width: 100px">Trạng thái</th>
                                        <th style="width: 150px">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lessons as $lesson)
                                    <tr>
                                        <td>{{ $lesson->id }}</td>
                                        <td>
                                            <div class="font-weight-bold">{{ Str::limit($lesson->title, 40) }}</div>
                                            <small class="text-muted">{{ Str::limit($lesson->content, 50) }}</small>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ $lesson->course->title ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-secondary">{{ $lesson->order }}</span>
                                        </td>
                                        <td>{{ $lesson->duration }} phút</td>
                                        <td>
                                            @if($lesson->video_url)
                                                <a href="{{ $lesson->video_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-play"></i> Xem
                                                </a>
                                            @else
                                                <span class="text-muted">Không có</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($lesson->is_published)
                                                <span class="badge badge-success">Đã xuất bản</span>
                                            @else
                                                <span class="badge badge-secondary">Nháp</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.lessons.show', $lesson) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.lessons.edit', $lesson) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('admin.lessons.destroy', $lesson) }}" class="d-inline">
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
                            {{ $lessons->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-book-open fa-5x text-muted mb-4"></i>
                            <h4>Chưa có bài học nào</h4>
                            <p class="text-muted">Hãy tạo bài học đầu tiên cho khóa học của bạn</p>
                            <a href="{{ route('admin.lessons.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus mr-2"></i>Tạo Bài Học Đầu Tiên
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
