@extends('layouts.adminlte-pure')

@section('title', 'Chi Tiết Khóa Học - Admin')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Chi Tiết Khóa Học</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">Khóa Học</a></li>
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
                    <h3 class="card-title">{{ $course->title }}</h3>
                    <div class="card-tools">
                        @if($course->is_published)
                            <span class="badge badge-success">Đã xuất bản</span>
                        @else
                            <span class="badge badge-secondary">Nháp</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if($course->image)
                        <div class="text-center mb-3">
                            <img src="{{ $course->image }}" alt="{{ $course->title }}" 
                                 class="img-fluid" style="max-height: 300px;">
                        </div>
                    @endif

                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 200px;">ID</th>
                            <td>{{ $course->id }}</td>
                        </tr>
                        <tr>
                            <th>Tiêu đề</th>
                            <td>{{ $course->title }}</td>
                        </tr>
                        <tr>
                            <th>Slug</th>
                            <td><code>{{ $course->slug }}</code></td>
                        </tr>
                        <tr>
                            <th>Mô tả</th>
                            <td>{{ $course->description }}</td>
                        </tr>
                        <tr>
                            <th>Danh mục</th>
                            <td>
                                <span class="badge badge-info">{{ $course->category->name }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Giảng viên</th>
                            <td>{{ $course->instructor->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Cấp độ</th>
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
                        </tr>
                        <tr>
                            <th>Giá</th>
                            <td>
                                @if($course->price > 0)
                                    <span class="text-success font-weight-bold">{{ number_format($course->price) }}đ</span>
                                @else
                                    <span class="badge badge-success">Miễn phí</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Thời lượng</th>
                            <td>{{ $course->duration }} phút</td>
                        </tr>
                        <tr>
                            <th>Số bài học</th>
                            <td>{{ $course->lessons()->count() }} bài</td>
                        </tr>
                        <tr>
                            <th>Số học viên</th>
                            <td>{{ $course->enrollments()->count() }} người</td>
                        </tr>
                        <tr>
                            <th>Trạng thái</th>
                            <td>
                                @if($course->is_published)
                                    <span class="badge badge-success">Đã xuất bản</span>
                                @else
                                    <span class="badge badge-secondary">Nháp</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Ngày tạo</th>
                            <td>{{ $course->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Cập nhật lần cuối</th>
                            <td>{{ $course->updated_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
                
                <div class="card-footer">
                    <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-primary">
                        <i class="fas fa-edit mr-2"></i>Chỉnh sửa
                    </a>
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
                        <i class="fas fa-list mr-2"></i>Danh sách
                    </a>
                    <a href="{{ route('courses.show', $course->slug) }}" class="btn btn-info" target="_blank">
                        <i class="fas fa-external-link-alt mr-2"></i>Xem trên website
                    </a>
                    <form method="POST" action="{{ route('admin.courses.destroy', $course) }}" class="d-inline">
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
                    <h3 class="card-title">Bài học trong khóa học</h3>
                </div>
                <div class="card-body">
                    @if($course->lessons->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($course->lessons->take(10) as $lesson)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $lesson->order }}. {{ Str::limit($lesson->title, 25) }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $lesson->duration }} phút</small>
                                    </div>
                                    <div>
                                        @if($lesson->is_published)
                                            <span class="badge badge-success">Đã xuất bản</span>
                                        @else
                                            <span class="badge badge-warning">Nháp</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @if($course->lessons->count() > 10)
                            <div class="text-center mt-3">
                                <a href="{{ route('admin.lessons.index', ['course' => $course->id]) }}" class="btn btn-sm btn-outline-primary">
                                    Xem tất cả ({{ $course->lessons->count() }})
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center text-muted">
                            <i class="fas fa-book-open fa-3x mb-3"></i>
                            <p>Chưa có bài học nào trong khóa học này</p>
                            <a href="{{ route('admin.lessons.create', ['course_id' => $course->id]) }}" class="btn btn-sm btn-primary">
                                Tạo bài học mới
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Học viên đăng ký</h3>
                </div>
                <div class="card-body">
                    @php
                        $enrollments = $course->enrollments()->with('user')->take(5)->get();
                    @endphp
                    
                    @if($enrollments->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($enrollments as $enrollment)
                                <div class="list-group-item d-flex align-items-center">
                                    <img src="{{ $enrollment->user->avatar ?? 'https://via.placeholder.com/32x32/007bff/ffffff?text=' . substr($enrollment->user->name, 0, 1) }}" 
                                         class="img-circle mr-2" width="32" height="32" alt="{{ $enrollment->user->name }}">
                                    <div>
                                        <strong>{{ $enrollment->user->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $enrollment->enrolled_at->format('d/m/Y') }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @if($course->enrollments()->count() > 5)
                            <div class="text-center mt-3">
                                <small class="text-muted">Và {{ $course->enrollments()->count() - 5 }} học viên khác</small>
                            </div>
                        @endif
                    @else
                        <div class="text-center text-muted">
                            <i class="fas fa-users fa-3x mb-3"></i>
                            <p>Chưa có học viên nào đăng ký</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
