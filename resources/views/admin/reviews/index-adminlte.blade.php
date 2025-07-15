@extends('layouts.adminlte-pure')

@section('title', 'Quản lý đánh giá')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Quản lý đánh giá</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Đánh giá</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Filters -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Bộ lọc</h3>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.reviews.index') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <select name="status" class="form-control">
                                        <option value="">Tất cả</option>
                                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Đã duyệt</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Khóa học</label>
                                    <select name="course_id" class="form-control">
                                        <option value="">Tất cả khóa học</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                                {{ $course->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tìm kiếm</label>
                                    <input type="text" name="search" class="form-control" placeholder="Tìm theo tên, khóa học, nội dung..." value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> Lọc
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Reviews Table -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh sách đánh giá ({{ $reviews->total() }})</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-success btn-sm" onclick="bulkAction('approve')">
                            <i class="fas fa-check"></i> Duyệt đã chọn
                        </button>
                        <button type="button" class="btn btn-warning btn-sm" onclick="bulkAction('reject')">
                            <i class="fas fa-times"></i> Từ chối đã chọn
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="bulkAction('delete')">
                            <i class="fas fa-trash"></i> Xóa đã chọn
                        </button>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <form id="bulkForm" method="POST">
                        @csrf
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" id="selectAll">
                                    </th>
                                    <th>Người đánh giá</th>
                                    <th>Khóa học</th>
                                    <th>Đánh giá</th>
                                    <th>Nội dung</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reviews as $review)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="review_ids[]" value="{{ $review->id }}" class="review-checkbox">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $review->user->avatar ?? 'https://via.placeholder.com/40' }}" 
                                                     alt="Avatar" class="img-circle mr-2" style="width: 30px; height: 30px;">
                                                <div>
                                                    <strong>{{ $review->user->name }}</strong><br>
                                                    <small class="text-muted">{{ $review->user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('courses.show', $review->course) }}" target="_blank">
                                                {{ $review->course->title }}
                                            </a>
                                        </td>
                                        <td>
                                            <div class="rating">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                                @endfor
                                                <span class="ml-1">({{ $review->rating }}/5)</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="max-width: 200px;">
                                                {{ $review->comment_excerpt }}
                                                @if(strlen($review->comment) > 100)
                                                    <a href="{{ route('admin.reviews.show', $review) }}" class="text-primary">...xem thêm</a>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @if($review->is_approved)
                                                <span class="badge badge-success">Đã duyệt</span>
                                            @else
                                                <span class="badge badge-warning">Chờ duyệt</span>
                                            @endif
                                        </td>
                                        <td>{{ $review->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.reviews.show', $review) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if($review->is_approved)
                                                    <form method="POST" action="{{ route('admin.reviews.reject', $review) }}" style="display: inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Từ chối duyệt đánh giá này?')">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form method="POST" action="{{ route('admin.reviews.approve', $review) }}" style="display: inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-success btn-sm">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Xóa đánh giá này?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Không có đánh giá nào</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </form>
                </div>
                @if($reviews->hasPages())
                    <div class="card-footer">
                        {{ $reviews->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
// Select all functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.review-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Bulk actions
function bulkAction(action) {
    const checkedBoxes = document.querySelectorAll('.review-checkbox:checked');
    if (checkedBoxes.length === 0) {
        alert('Vui lòng chọn ít nhất một đánh giá');
        return;
    }

    let confirmMessage = '';
    let actionUrl = '';

    switch(action) {
        case 'approve':
            confirmMessage = `Duyệt ${checkedBoxes.length} đánh giá đã chọn?`;
            actionUrl = '{{ route("admin.reviews.bulk-approve") }}';
            break;
        case 'reject':
            confirmMessage = `Từ chối ${checkedBoxes.length} đánh giá đã chọn?`;
            actionUrl = '{{ route("admin.reviews.bulk-reject") }}';
            break;
        case 'delete':
            confirmMessage = `Xóa ${checkedBoxes.length} đánh giá đã chọn? Hành động này không thể hoàn tác.`;
            actionUrl = '{{ route("admin.reviews.bulk-delete") }}';
            break;
    }

    if (confirm(confirmMessage)) {
        const form = document.getElementById('bulkForm');
        form.action = actionUrl;
        form.submit();
    }
}
</script>
@endpush
@endsection
