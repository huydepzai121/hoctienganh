@extends('layouts.adminlte-pure')

@section('title', 'Tạo Người Dùng Mới - Admin')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Tạo Người Dùng Mới</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Người Dùng</a></li>
                <li class="breadcrumb-item active">Tạo Mới</li>
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
                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Mật khẩu <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Tối thiểu 8 ký tự</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation" required>
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
                                        <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Học viên</option>
                                        <option value="instructor" {{ old('role') == 'instructor' ? 'selected' : '' }}>Giảng viên</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
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
                                           id="phone" name="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="avatar">Avatar (URL)</label>
                            <input type="url" class="form-control @error('avatar') is-invalid @enderror" 
                                   id="avatar" name="avatar" value="{{ old('avatar') }}">
                            @error('avatar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">URL hình ảnh đại diện</small>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i>Lưu người dùng
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times mr-2"></i>Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Hướng dẫn</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h5><i class="fas fa-info-circle mr-2"></i>Lưu ý:</h5>
                        <ul class="mb-0">
                            <li><strong>Admin:</strong> Toàn quyền quản trị</li>
                            <li><strong>Giảng viên:</strong> Tạo và quản lý khóa học</li>
                            <li><strong>Học viên:</strong> Đăng ký và học khóa học</li>
                            <li>Email phải là duy nhất</li>
                            <li>Mật khẩu tối thiểu 8 ký tự</li>
                        </ul>
                    </div>
                    
                    <div class="alert alert-warning">
                        <h6><i class="fas fa-exclamation-triangle mr-2"></i>Bảo mật:</h6>
                        <p class="mb-0">Tài khoản sẽ được tự động xác thực email. Hãy đảm bảo email chính xác.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
