@extends('layouts.adminlte-pure')

@section('title', 'Chi tiết đánh giá')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Chi tiết đánh giá</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.reviews.index') }}">Đánh giá</a></li>
                        <li class="breadcrumb-item active">Chi tiết</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <!-- Review Details -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin đánh giá</h3>
                            <div class="card-tools">
                                @if($review->is_approved)
                                    <span class="badge badge-success">Đã duyệt</span>
                                @else
                                    <span class="badge badge-warning">Chờ duyệt</span>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Rating -->
                            <div class="mb-4">
                                <h5>Đánh giá:</h5>
                                <div class="rating mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}" style="font-size: 1.5rem;"></i>
                                    @endfor
                                    <span class="ml-2 h5">{{ $review->rating }}/5</span>
                                </div>
                            </div>

                            <!-- Comment -->
                            @if($review->comment)
                                <div class="mb-4">
                                    <h5>Nhận xét:</h5>
                                    <div class="border p-3 rounded bg-light">
                                        {{ $review->comment }}
                                    </div>
                                </div>
                            @endif

                            <!-- Timestamps -->
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Ngày tạo:</strong><br>
                                    {{ $review->created_at->format('d/m/Y H:i:s') }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Cập nhật lần cuối:</strong><br>
                                    {{ $review->updated_at->format('d/m/Y H:i:s') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- User Info -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Người đánh giá</h3>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <img src="{{ $review->user->avatar ?? 'https://via.placeholder.com/100' }}" 
                                     alt="Avatar" class="img-circle" style="width: 80px; height: 80px;">
                            </div>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Tên:</strong></td>
                                    <td>{{ $review->user->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $review->user->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Vai trò:</strong></td>
                                    <td>
                                        <span class="badge badge-info">{{ ucfirst($review->user->role->name) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Tham gia:</strong></td>
                                    <td>{{ $review->user->created_at->format('d/m/Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Course Info -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Khóa học</h3>
                        </div>
                        <div class="card-body">
                            @if($review->course->image)
                                <div class="text-center mb-3">
                                    <img src="{{ $review->course->image }}" alt="Course Image" class="img-fluid rounded" style="max-height: 120px;">
                                </div>
                            @endif
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Tên khóa học:</strong></td>
                                    <td>
                                        <a href="{{ route('courses.show', $review->course) }}" target="_blank">
                                            {{ $review->course->title }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Danh mục:</strong></td>
                                    <td>{{ $review->course->category->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Giảng viên:</strong></td>
                                    <td>{{ $review->course->instructor->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Đánh giá TB:</strong></td>
                                    <td>
                                        <div class="rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $review->course->average_rating ? 'text-warning' : 'text-muted' }}"></i>
                                            @endfor
                                            <span class="ml-1">({{ number_format($review->course->average_rating, 1) }})</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Số đánh giá:</strong></td>
                                    <td>{{ $review->course->review_count }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thao tác</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                @if($review->is_approved)
                                    <form method="POST" action="{{ route('admin.reviews.reject', $review) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-warning btn-block" onclick="return confirm('Từ chối duyệt đánh giá này?')">
                                            <i class="fas fa-times"></i> Từ chối duyệt
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.reviews.approve', $review) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-block">
                                            <i class="fas fa-check"></i> Duyệt đánh giá
                                        </button>
                                    </form>
                                @endif

                                <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Xóa đánh giá này? Hành động này không thể hoàn tác.')">
                                        <i class="fas fa-trash"></i> Xóa đánh giá
                                    </button>
                                </form>

                                <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary btn-block">
                                    <i class="fas fa-arrow-left"></i> Quay lại danh sách
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
