@extends('layouts.adminlte-pure')

@section('title', 'Chi tiết đánh giá')

@push('styles')
<style>
.review-detail-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.review-detail-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 15px rgba(0,0,0,0.15);
}

.rating-display {
    background: linear-gradient(135deg, #ffc107 0%, #ff8f00 100%);
    color: white;
    padding: 2rem;
    border-radius: 15px;
    text-align: center;
    margin-bottom: 2rem;
}

.rating-stars {
    font-size: 2rem;
    margin: 1rem 0;
}

.rating-number {
    font-size: 3rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.user-profile-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px;
    padding: 2rem;
    text-align: center;
}

.user-avatar-large {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    border: 4px solid white;
    margin-bottom: 1rem;
}

.course-info-card {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
    border-radius: 15px;
    padding: 2rem;
}

.course-thumbnail-large {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 1rem;
}

.action-card {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 2rem;
}

.action-btn {
    border-radius: 10px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    transition: all 0.3s ease;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.comment-box {
    background: #f8f9fa;
    border: 2px solid #e9ecef;
    border-radius: 15px;
    padding: 2rem;
    font-size: 1.1rem;
    line-height: 1.6;
}

.info-table {
    background: white;
    border-radius: 10px;
    overflow: hidden;
}

.info-table td {
    padding: 1rem;
    border-bottom: 1px solid #e9ecef;
}

.info-table td:first-child {
    background: #f8f9fa;
    font-weight: 600;
    width: 40%;
}

.status-badge-large {
    font-size: 1rem;
    padding: 0.5rem 1rem;
    border-radius: 25px;
}

.timeline-item {
    border-left: 3px solid #667eea;
    padding-left: 1rem;
    margin-bottom: 1rem;
}

.timeline-time {
    color: #6c757d;
    font-size: 0.9rem;
}
</style>
@endpush

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark font-weight-bold">
                        <i class="fas fa-star text-warning mr-2"></i>
                        Chi tiết đánh giá
                    </h1>
                    <p class="text-muted">Xem thông tin chi tiết về đánh giá từ học viên</p>
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
            <!-- Status Banner -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="alert {{ $review->is_approved ? 'alert-success' : 'alert-warning' }} alert-dismissible">
                        <h5>
                            <i class="icon fas {{ $review->is_approved ? 'fa-check-circle' : 'fa-clock' }}"></i>
                            Trạng thái: {{ $review->is_approved ? 'Đã duyệt' : 'Chờ duyệt' }}
                        </h5>
                        {{ $review->is_approved ? 'Đánh giá này đã được duyệt và hiển thị công khai.' : 'Đánh giá này đang chờ được duyệt.' }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <!-- Rating Display -->
                    <div class="rating-display">
                        <div class="rating-number">{{ $review->rating }}</div>
                        <div class="rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $review->rating ? '' : 'text-white-50' }}"></i>
                            @endfor
                        </div>
                        <div class="h5 mb-0">trên 5 sao</div>
                    </div>

                    <!-- Review Content -->
                    <div class="review-detail-card card">
                        <div class="card-header bg-white">
                            <h4 class="card-title mb-0">
                                <i class="fas fa-comment-alt text-primary mr-2"></i>
                                Nội dung đánh giá
                            </h4>
                        </div>
                        <div class="card-body">
                            @if($review->comment)
                                <div class="comment-box">
                                    <i class="fas fa-quote-left text-muted mr-2"></i>
                                    {{ $review->comment }}
                                    <i class="fas fa-quote-right text-muted ml-2"></i>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-comment-slash fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Học viên chỉ đánh giá sao mà không có nhận xét bằng văn bản.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="review-detail-card card">
                        <div class="card-header bg-white">
                            <h4 class="card-title mb-0">
                                <i class="fas fa-history text-info mr-2"></i>
                                Lịch sử
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="timeline-item">
                                <div class="font-weight-bold">Đánh giá được tạo</div>
                                <div class="timeline-time">{{ $review->created_at->format('d/m/Y H:i:s') }}</div>
                            </div>
                            @if($review->created_at != $review->updated_at)
                                <div class="timeline-item">
                                    <div class="font-weight-bold">Cập nhật lần cuối</div>
                                    <div class="timeline-time">{{ $review->updated_at->format('d/m/Y H:i:s') }}</div>
                                </div>
                            @endif
                            @if($review->is_approved)
                                <div class="timeline-item">
                                    <div class="font-weight-bold text-success">Đánh giá được duyệt</div>
                                    <div class="timeline-time">{{ $review->updated_at->format('d/m/Y H:i:s') }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- User Info -->
                    <div class="user-profile-card mb-4">
                        <img src="{{ $review->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($review->user->name) . '&background=fff&color=667eea&size=200' }}"
                             alt="Avatar" class="user-avatar-large">
                        <h4 class="font-weight-bold mb-2">{{ $review->user->name }}</h4>
                        <p class="mb-3 opacity-75">{{ $review->user->email }}</p>
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="font-weight-bold">{{ $review->user->reviews()->count() }}</div>
                                <small>Đánh giá</small>
                            </div>
                            <div class="col-6">
                                <div class="font-weight-bold">{{ $review->user->created_at->format('m/Y') }}</div>
                                <small>Tham gia</small>
                            </div>
                        </div>
                    </div>

                    <!-- Course Info -->
                    <div class="course-info-card mb-4">
                        @if($review->course->image)
                            <img src="{{ $review->course->image }}" alt="Course Image" class="course-thumbnail-large">
                        @else
                            <div class="course-thumbnail-large bg-white bg-opacity-25 d-flex align-items-center justify-content-center">
                                <i class="fas fa-book fa-3x text-white"></i>
                            </div>
                        @endif

                        <h5 class="font-weight-bold mb-2">
                            <a href="{{ route('courses.show', $review->course) }}" target="_blank" class="text-white text-decoration-none">
                                {{ $review->course->title }}
                                <i class="fas fa-external-link-alt ml-2 small"></i>
                            </a>
                        </h5>

                        <div class="row text-center mb-3">
                            <div class="col-4">
                                <div class="font-weight-bold">{{ number_format($review->course->average_rating, 1) }}</div>
                                <small>Điểm TB</small>
                            </div>
                            <div class="col-4">
                                <div class="font-weight-bold">{{ $review->course->review_count }}</div>
                                <small>Đánh giá</small>
                            </div>
                            <div class="col-4">
                                <div class="font-weight-bold">{{ $review->course->students()->count() }}</div>
                                <small>Học viên</small>
                            </div>
                        </div>

                        <div class="small opacity-75">
                            <div><i class="fas fa-tag mr-2"></i>{{ $review->course->category->name }}</div>
                            <div><i class="fas fa-user mr-2"></i>{{ $review->course->instructor->name }}</div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="action-card">
                        <h5 class="font-weight-bold mb-3">
                            <i class="fas fa-cogs text-primary mr-2"></i>
                            Thao tác
                        </h5>

                        <div class="d-grid gap-2">
                            @if($review->is_approved)
                                <form method="POST" action="{{ route('admin.reviews.reject', $review) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-warning action-btn btn-block" onclick="return confirmAction('Từ chối duyệt đánh giá này?')">
                                        <i class="fas fa-times mr-2"></i>Từ chối duyệt
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('admin.reviews.approve', $review) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success action-btn btn-block">
                                        <i class="fas fa-check mr-2"></i>Duyệt đánh giá
                                    </button>
                                </form>
                            @endif

                            <hr>

                            <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger action-btn btn-block" onclick="return confirmAction('Xóa đánh giá này? Hành động này không thể hoàn tác.', 'error')">
                                    <i class="fas fa-trash mr-2"></i>Xóa đánh giá
                                </button>
                            </form>

                            <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary action-btn btn-block">
                                <i class="fas fa-arrow-left mr-2"></i>Quay lại danh sách
                            </a>

                            <a href="{{ route('courses.show', $review->course) }}" target="_blank" class="btn btn-info action-btn btn-block">
                                <i class="fas fa-external-link-alt mr-2"></i>Xem khóa học
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
function confirmAction(message, type = 'warning') {
    return new Promise((resolve) => {
        Swal.fire({
            title: 'Xác nhận',
            text: message,
            icon: type,
            showCancelButton: true,
            confirmButtonColor: type === 'error' ? '#dc3545' : '#667eea',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Xác nhận',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            resolve(result.isConfirmed);
        });
    });
}

// Add loading state to action buttons
$('form button[type="submit"]').click(function(e) {
    e.preventDefault();
    const button = $(this);
    const form = button.closest('form');
    const originalHtml = button.html();

    const message = button.hasClass('btn-danger')
        ? 'Xóa đánh giá này? Hành động này không thể hoàn tác.'
        : button.hasClass('btn-warning')
        ? 'Từ chối duyệt đánh giá này?'
        : 'Duyệt đánh giá này?';

    const type = button.hasClass('btn-danger') ? 'error' : 'warning';

    confirmAction(message, type).then((confirmed) => {
        if (confirmed) {
            button.html('<i class="fas fa-spinner fa-spin mr-2"></i>Đang xử lý...').prop('disabled', true);
            form.submit();
        }
    });
});

// Add smooth scroll to top when page loads
$(document).ready(function() {
    $('html, body').animate({scrollTop: 0}, 'slow');
});
</script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
@endsection
