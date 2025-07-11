@extends('layouts.adminlte-pure')

@section('title', 'Quản Lý Người Dùng - Admin')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Quản Lý Người Dùng</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Người Dùng</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh Sách Người Dùng</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-2"></i>Thêm Người Dùng
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($users->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">ID</th>
                                        <th>Avatar</th>
                                        <th>Tên</th>
                                        <th>Email</th>
                                        <th>Vai trò</th>
                                        <th>Điện thoại</th>
                                        <th style="width: 100px">Ngày tạo</th>
                                        <th style="width: 150px">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>
                                            <img src="{{ $user->avatar ?? 'https://via.placeholder.com/40x40/007bff/ffffff?text=' . substr($user->name, 0, 1) }}" 
                                                 class="img-circle" width="40" height="40" alt="{{ $user->name }}">
                                        </td>
                                        <td>
                                            <div class="font-weight-bold">{{ $user->name }}</div>
                                            @if($user->email_verified_at)
                                                <small class="text-success"><i class="fas fa-check-circle"></i> Đã xác thực</small>
                                            @else
                                                <small class="text-warning"><i class="fas fa-exclamation-circle"></i> Chưa xác thực</small>
                                            @endif
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if(is_string($user->role))
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
                                            @elseif(is_object($user->role) && isset($user->role->name))
                                                @switch($user->role->name)
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
                                                        <span class="badge badge-secondary">{{ ucfirst($user->role->name) }}</span>
                                                @endswitch
                                            @else
                                                <span class="badge badge-secondary">N/A</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->phone ?? 'N/A' }}</td>
                                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($user->id !== auth()->id())
                                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger btn-delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $users->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-5x text-muted mb-4"></i>
                            <h4>Chưa có người dùng nào</h4>
                            <p class="text-muted">Hãy thêm người dùng đầu tiên</p>
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus mr-2"></i>Thêm Người Dùng Đầu Tiên
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
