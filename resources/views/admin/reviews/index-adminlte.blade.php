@extends('layouts.adminlte-pure')

@section('title', 'Quản lý đánh giá')

@push('styles')
<style>
.review-card {
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.review-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.rating-stars {
    color: #ffc107;
    font-size: 1.1rem;
}

.rating-stars .fa-star {
    margin-right: 2px;
}

.status-badge {
    font-size: 0.85rem;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.course-thumbnail {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    object-fit: cover;
}

.review-content {
    max-width: 300px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.action-buttons .btn {
    margin: 0 2px;
    border-radius: 6px;
    padding: 0.375rem 0.75rem;
}

.stats-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 1rem;
}

.stats-number {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.filter-card {
    background: #f8f9fa;
    border: none;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.table-modern {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.table-modern thead th {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 1rem;
    font-weight: 600;
}

.table-modern tbody td {
    padding: 1rem;
    border-bottom: 1px solid #e9ecef;
    vertical-align: middle;
}

.bulk-actions {
    background: white;
    padding: 1rem;
    border-radius: 10px;
    margin-bottom: 1rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.search-box {
    border-radius: 25px;
    border: 2px solid #e9ecef;
    padding: 0.75rem 1.5rem;
    transition: all 0.3s ease;
}

.search-box:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.btn-modern {
    border-radius: 8px;
    padding: 0.5rem 1.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-modern:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.empty-state {
    text-align: center;
    padding: 3rem;
    color: #6c757d;
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}
</style>
@endpush

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark font-weight-bold">
            <i class="fas fa-star text-warning mr-2"></i>
            Quản lý đánh giá
        </h1>
        <p class="text-muted">Quản lý và duyệt đánh giá từ học viên</p>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Đánh giá</li>
        </ol>
    </div>
</div>
@endsection

@section('content')

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="stats-card">
            <div class="stats-number">{{ number_format($reviews->total()) }}</div>
            <div class="stats-label">
                <i class="fas fa-star mr-2"></i>Tổng đánh giá
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stats-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <div class="stats-number">{{ $reviews->where('is_approved', false)->count() }}</div>
            <div class="stats-label">
                <i class="fas fa-clock mr-2"></i>Chờ duyệt
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stats-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div class="stats-number">{{ $reviews->where('is_approved', true)->count() }}</div>
            <div class="stats-label">
                <i class="fas fa-check-circle mr-2"></i>Đã duyệt
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stats-card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
            <div class="stats-number">{{ number_format($reviews->avg('rating'), 1) }}</div>
            <div class="stats-label">
                <i class="fas fa-chart-line mr-2"></i>Điểm TB
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card filter-card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reviews.index') }}" class="row align-items-end">
            <div class="col-md-3">
                <label class="form-label font-weight-bold">
                    <i class="fas fa-filter mr-1"></i>Trạng thái
                </label>
                <select name="status" class="form-control">
                    <option value="">Tất cả trạng thái</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>
                        <i class="fas fa-clock"></i> Chờ duyệt
                    </option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>
                        <i class="fas fa-check"></i> Đã duyệt
                    </option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label font-weight-bold">
                    <i class="fas fa-book mr-1"></i>Khóa học
                </label>
                <select name="course_id" class="form-control">
                    <option value="">Tất cả khóa học</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label font-weight-bold">
                    <i class="fas fa-search mr-1"></i>Tìm kiếm
                </label>
                <input type="text" name="search" class="form-control search-box"
                       placeholder="Tìm theo tên, khóa học, nội dung..."
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-modern btn-block">
                    <i class="fas fa-search mr-2"></i>Lọc
                </button>
            </div>
        </form>
    </div>
</div>

            <!-- Bulk Actions -->
            <div class="bulk-actions">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="mb-0 font-weight-bold">
                            <i class="fas fa-list mr-2 text-primary"></i>
                            Danh sách đánh giá ({{ number_format($reviews->total()) }})
                        </h5>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-success btn-modern" onclick="bulkAction('approve')">
                            <i class="fas fa-check mr-2"></i>Duyệt đã chọn
                        </button>
                        <button type="button" class="btn btn-warning btn-modern" onclick="bulkAction('reject')">
                            <i class="fas fa-times mr-2"></i>Từ chối đã chọn
                        </button>
                        <button type="button" class="btn btn-danger btn-modern" onclick="bulkAction('delete')">
                            <i class="fas fa-trash mr-2"></i>Xóa đã chọn
                        </button>
                    </div>
                </div>
            </div>

            <!-- Reviews Table -->
            <div class="table-modern">
                <form id="bulkForm" method="POST">
                    @csrf
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th style="width: 50px;">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="selectAll">
                                        <label class="custom-control-label" for="selectAll"></label>
                                    </div>
                                </th>
                                <th>Người đánh giá</th>
                                <th>Khóa học</th>
                                <th>Đánh giá</th>
                                <th>Nội dung</th>
                                <th>Trạng thái</th>
                                <th>Ngày tạo</th>
                                <th style="width: 150px;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reviews as $review)
                                <tr class="review-row">
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="review_ids[]" value="{{ $review->id }}"
                                                   class="custom-control-input review-checkbox" id="review_{{ $review->id }}">
                                            <label class="custom-control-label" for="review_{{ $review->id }}"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $review->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($review->user->name) . '&background=667eea&color=fff' }}"
                                                 alt="Avatar" class="user-avatar mr-3">
                                            <div>
                                                <div class="font-weight-bold text-dark">{{ $review->user->name }}</div>
                                                <small class="text-muted">{{ $review->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($review->course->image)
                                                <img src="{{ $review->course->image }}" alt="Course" class="course-thumbnail mr-3">
                                            @else
                                                <div class="course-thumbnail mr-3 bg-primary d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-book text-white"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <a href="{{ route('courses.show', $review->course) }}" target="_blank"
                                                   class="font-weight-bold text-primary text-decoration-none">
                                                    {{ Str::limit($review->course->title, 30) }}
                                                </a>
                                                <br>
                                                <small class="text-muted">{{ $review->course->category->name }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="rating-stars">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $review->rating ? '' : 'text-muted' }}"></i>
                                            @endfor
                                        </div>
                                        <div class="font-weight-bold text-dark mt-1">{{ $review->rating }}/5</div>
                                    </td>
                                    <td>
                                        <div class="review-content">
                                            @if($review->comment)
                                                <p class="mb-1">{{ Str::limit($review->comment, 80) }}</p>
                                                @if(strlen($review->comment) > 80)
                                                    <a href="{{ route('admin.reviews.show', $review) }}" class="text-primary small">
                                                        <i class="fas fa-external-link-alt mr-1"></i>Xem đầy đủ
                                                    </a>
                                                @endif
                                            @else
                                                <span class="text-muted font-italic">Không có nhận xét</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($review->is_approved)
                                            <span class="badge badge-success status-badge">
                                                <i class="fas fa-check mr-1"></i>Đã duyệt
                                            </span>
                                        @else
                                            <span class="badge badge-warning status-badge">
                                                <i class="fas fa-clock mr-1"></i>Chờ duyệt
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="font-weight-bold">{{ $review->created_at->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ $review->created_at->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.reviews.show', $review) }}"
                                               class="btn btn-info btn-sm" title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($review->is_approved)
                                                <form method="POST" action="{{ route('admin.reviews.reject', $review) }}" style="display: inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-warning btn-sm"
                                                            onclick="return confirm('Từ chối duyệt đánh giá này?')" title="Từ chối">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('admin.reviews.approve', $review) }}" style="display: inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-success btn-sm" title="Duyệt">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Xóa đánh giá này?')" title="Xóa">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="empty-state">
                                            <i class="fas fa-star"></i>
                                            <h5>Không có đánh giá nào</h5>
                                            <p>Chưa có đánh giá nào phù hợp với bộ lọc hiện tại.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </form>

                @if($reviews->hasPages())
                    <div class="p-3 bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                Hiển thị {{ $reviews->firstItem() }} - {{ $reviews->lastItem() }}
                                trong tổng số {{ number_format($reviews->total()) }} đánh giá
                            </div>
                            <div>
                                {{ $reviews->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Select all functionality
    $('#selectAll').change(function() {
        $('.review-checkbox').prop('checked', this.checked);
        updateBulkActionButtons();
    });

    // Individual checkbox change
    $('.review-checkbox').change(function() {
        updateBulkActionButtons();

        // Update select all checkbox
        const totalCheckboxes = $('.review-checkbox').length;
        const checkedCheckboxes = $('.review-checkbox:checked').length;

        if (checkedCheckboxes === 0) {
            $('#selectAll').prop('indeterminate', false).prop('checked', false);
        } else if (checkedCheckboxes === totalCheckboxes) {
            $('#selectAll').prop('indeterminate', false).prop('checked', true);
        } else {
            $('#selectAll').prop('indeterminate', true);
        }
    });

    // Update bulk action button states
    function updateBulkActionButtons() {
        const checkedCount = $('.review-checkbox:checked').length;
        const bulkButtons = $('.bulk-actions button');

        if (checkedCount > 0) {
            bulkButtons.removeClass('disabled').prop('disabled', false);
            bulkButtons.find('.badge').remove();
            bulkButtons.append(`<span class="badge badge-light ml-1">${checkedCount}</span>`);
        } else {
            bulkButtons.addClass('disabled').prop('disabled', true);
            bulkButtons.find('.badge').remove();
        }
    }

    // Initialize button states
    updateBulkActionButtons();

    // Add hover effects to table rows
    $('.review-row').hover(
        function() {
            $(this).addClass('table-active');
        },
        function() {
            $(this).removeClass('table-active');
        }
    );
});

// Bulk actions with SweetAlert
function bulkAction(action) {
    const checkedBoxes = document.querySelectorAll('.review-checkbox:checked');
    if (checkedBoxes.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Chưa chọn đánh giá',
            text: 'Vui lòng chọn ít nhất một đánh giá để thực hiện hành động này.',
            confirmButtonColor: '#667eea'
        });
        return;
    }

    let title = '';
    let text = '';
    let icon = '';
    let confirmButtonText = '';
    let actionUrl = '';

    switch(action) {
        case 'approve':
            title = 'Duyệt đánh giá';
            text = `Bạn có chắc muốn duyệt ${checkedBoxes.length} đánh giá đã chọn?`;
            icon = 'question';
            confirmButtonText = 'Duyệt';
            actionUrl = '{{ route("admin.reviews.bulk-approve") }}';
            break;
        case 'reject':
            title = 'Từ chối đánh giá';
            text = `Bạn có chắc muốn từ chối ${checkedBoxes.length} đánh giá đã chọn?`;
            icon = 'warning';
            confirmButtonText = 'Từ chối';
            actionUrl = '{{ route("admin.reviews.bulk-reject") }}';
            break;
        case 'delete':
            title = 'Xóa đánh giá';
            text = `Bạn có chắc muốn xóa ${checkedBoxes.length} đánh giá đã chọn? Hành động này không thể hoàn tác.`;
            icon = 'error';
            confirmButtonText = 'Xóa';
            actionUrl = '{{ route("admin.reviews.bulk-delete") }}';
            break;
    }

    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: action === 'delete' ? '#dc3545' : '#667eea',
        cancelButtonColor: '#6c757d',
        confirmButtonText: confirmButtonText,
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('bulkForm');
            form.action = actionUrl;
            form.submit();
        }
    });
}

// Add loading state to action buttons
$('form button[type="submit"]').click(function() {
    const button = $(this);
    const originalHtml = button.html();

    button.html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);

    // Re-enable after 3 seconds as fallback
    setTimeout(() => {
        button.html(originalHtml).prop('disabled', false);
    }, 3000);
});
</script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
@endsection
