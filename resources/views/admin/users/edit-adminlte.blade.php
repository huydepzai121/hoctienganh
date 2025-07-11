@extends('layouts.adminlte-pure')

@section('title', 'Chỉnh Sửa Người Dùng - Admin')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Chỉnh Sửa Người Dùng</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Người Dùng</a></li>
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
                    <h3 class="card-title">Thông tin người dùng</h3>
                </div>
                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Mật khẩu mới</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Để trống nếu không muốn thay đổi</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Xác nhận mật khẩu mới</label>
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role">Vai trò <span class="text-danger">*</span></label>
                                    <select class="form-control @error('role') is-invalid @enderror" 
                                            id="role" name="role" required>
                                        <option value="">Chọn vai trò</option>
                                        <option value="student" {{ old('role', $user->role) == 'student' ? 'selected' : '' }}>Học viên</option>
                                        <option value="instructor" {{ old('role', $user->role) == 'instructor' ? 'selected' : '' }}>Giảng viên</option>
                                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Số điện thoại</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="avatar">Avatar (URL)</label>
                            <input type="url" class="form-control @error('avatar') is-invalid @enderror" 
                                   id="avatar" name="avatar" value="{{ old('avatar', $user->avatar) }}">
                            @error('avatar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">URL hình ảnh đại diện</small>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i>Cập nhật người dùng
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times mr-2"></i>Hủy
                        </a>
                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-info">
                            <i class="fas fa-eye mr-2"></i>Xem chi tiết
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thông tin hiện tại</h3>
                </div>
                <div class="card-body">
                    @if($user->avatar)
                        <div class="text-center mb-3">
                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" 
                                 class="img-circle" width="100" height="100">
                        </div>
                    @endif
                    
                    <table class="table table-sm">
                        <tr>
                            <td><strong>ID:</strong></td>
                            <td>{{ $user->id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Vai trò hiện tại:</strong></td>
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
                            <td><strong>Email xác thực:</strong></td>
                            <td>
                                @if($user->email_verified_at)
                                    <span class="text-success"><i class="fas fa-check"></i> Đã xác thực</span>
                                @else
                                    <span class="text-warning"><i class="fas fa-times"></i> Chưa xác thực</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Ngày tạo:</strong></td>
                            <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Cập nhật:</strong></td>
                            <td>{{ $user->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            @if($user->role == 'instructor')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thống kê giảng viên</h3>
                </div>
                <div class="card-body">
                    <div class="row text-center">
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
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
