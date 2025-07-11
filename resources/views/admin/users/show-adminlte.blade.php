@extends('layouts.adminlte-pure')

@section('title', 'Chi Tiết Người Dùng - Admin')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Chi Tiết Người Dùng</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Người Dùng</a></li>
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
                    <h3 class="card-title">{{ $user->name }}</h3>
                    <div class="card-tools">
                        @switch($user->role)
                            @case('admin')
                                <span class="badge badge-danger">Admin</span>
                                @break
                            @case('instructor')
                                <span class="badge badge-warning">Giảng viên</span>
                                @break
                            @case('student')
                                <span class="badge badge-info">Học viên</span>
                                @break
                            @default
                                <span class="badge badge-secondary">{{ ucfirst($user->role) }}</span>
                        @endswitch
                    </div>
                </div>
                <div class="card-body">
                    @if($user->avatar)
                        <div class="text-center mb-3">
                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" 
                                 class="img-circle" width="150" height="150">
                        </div>
                    @endif

                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 200px;">ID</th>
                            <td>{{ $user->id }}</td>
                        </tr>
                        <tr>
                            <th>Họ và tên</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>
                                {{ $user->email }}
                                @if($user->email_verified_at)
                                    <span class="badge badge-success ml-2">Đã xác thực</span>
                                @else
                                    <span class="badge badge-warning ml-2">Chưa xác thực</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Vai trò</th>
                            <td>
                                @switch($user->role)
                                    @case('admin')
                                        <span class="badge badge-danger">Admin</span>
                                        @break
                                    @case('instructor')
                                        <span class="badge badge-warning">Giảng viên</span>
                                        @break
                                    @case('student')
                                        <span class="badge badge-info">Học viên</span>
                                        @break
                                    @default
                                        <span class="badge badge-secondary">{{ ucfirst($user->role) }}</span>
                                @endswitch
                            </td>
                        </tr>
                        <tr>
                            <th>Số điện thoại</th>
                            <td>{{ $user->phone ?: 'Chưa cập nhật' }}</td>
                        </tr>
                        <tr>
                            <th>Avatar</th>
                            <td>
                                @if($user->avatar)
                                    <a href="{{ $user->avatar }}" target="_blank">{{ $user->avatar }}</a>
                                @else
                                    Chưa có avatar
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Trạng thái</th>
                            <td>
                                @if($user->is_active)
                                    <span class="badge badge-success">Hoạt động</span>
                                @else
                                    <span class="badge badge-secondary">Tạm khóa</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Ngày tạo</th>
                            <td>{{ $user->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Cập nhật lần cuối</th>
                            <td>{{ $user->updated_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
                
                <div class="card-footer">
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                        <i class="fas fa-edit mr-2"></i>Chỉnh sửa
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-list mr-2"></i>Danh sách
                    </a>
                    @if($user->id !== auth()->id())
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-delete">
                            <i class="fas fa-trash mr-2"></i>Xóa
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            @if($user->role == 'instructor')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Khóa học của giảng viên</h3>
                </div>
                <div class="card-body">
                    @php
                        $courses = $user->courses()->take(10)->get();
                    @endphp
                    
                    @if($courses->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($courses as $course)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ Str::limit($course->title, 25) }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            {{ $course->enrollments()->count() }} học viên
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
                        
                        @if($user->courses()->count() > 10)
                            <div class="text-center mt-3">
                                <a href="{{ route('admin.courses.index', ['instructor' => $user->id]) }}" class="btn btn-sm btn-outline-primary">
                                    Xem tất cả ({{ $user->courses()->count() }})
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center text-muted">
                            <i class="fas fa-book fa-3x mb-3"></i>
                            <p>Chưa có khóa học nào</p>
                        </div>
                    @endif
                </div>
            </div>
            @endif

            @if($user->role == 'student')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Khóa học đã đăng ký</h3>
                </div>
                <div class="card-body">
                    @if($user->enrollments->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($user->enrollments->take(10) as $enrollment)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ Str::limit($enrollment->course->title, 25) }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            Tiến độ: {{ $enrollment->progress }}%
                                        </small>
                                    </div>
                                    <div>
                                        @if($enrollment->is_active)
                                            <span class="badge badge-success">Đang học</span>
                                        @else
                                            <span class="badge badge-secondary">Tạm dừng</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @if($user->enrollments->count() > 10)
                            <div class="text-center mt-3">
                                <small class="text-muted">Và {{ $user->enrollments->count() - 10 }} khóa học khác</small>
                            </div>
                        @endif
                    @else
                        <div class="text-center text-muted">
                            <i class="fas fa-graduation-cap fa-3x mb-3"></i>
                            <p>Chưa đăng ký khóa học nào</p>
                        </div>
                    @endif
                </div>
            </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thống kê</h3>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        @if($user->role == 'instructor')
                        <div class="col-6">
                            <div class="description-block">
                                <h5 class="description-header">{{ $user->courses()->count() }}</h5>
                                <span class="description-text">Khóa học</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="description-block">
                                <h5 class="description-header">{{ $user->courses()->withCount('enrollments')->get()->sum('enrollments_count') }}</h5>
                                <span class="description-text">Học viên</span>
                            </div>
                        </div>
                        @elseif($user->role == 'student')
                        <div class="col-6">
                            <div class="description-block">
                                <h5 class="description-header">{{ $user->enrollments()->count() }}</h5>
                                <span class="description-text">Khóa học</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="description-block">
                                <h5 class="description-header">{{ $user->completedLessons()->count() }}</h5>
                                <span class="description-text">Bài học</span>
                            </div>
                        </div>
                        @else
                        <div class="col-12">
                            <div class="description-block">
                                <h5 class="description-header">{{ $user->created_at->diffForHumans() }}</h5>
                                <span class="description-text">Tham gia</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
