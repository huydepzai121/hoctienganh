@extends('layouts.adminlte-pure')

@section('title', 'Quản lý thảo luận')

@push('styles')
<style>
.discussion-card {
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.discussion-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
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

.category-badge {
    font-size: 0.8rem;
    padding: 0.3rem 0.6rem;
    border-radius: 15px;
    text-decoration: none;
    margin-right: 0.5rem;
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
}

.action-buttons .btn {
    margin: 0 2px;
    border-radius: 6px;
    padding: 0.375rem 0.75rem;
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

.pinned-badge {
    background: linear-gradient(45deg, #ffc107, #ff8f00);
    color: white;
    font-size: 0.7rem;
    padding: 0.2rem 0.5rem;
    border-radius: 10px;
    margin-right: 0.5rem;
}

.featured-badge {
    background: linear-gradient(45deg, #dc3545, #c82333);
    color: white;
    font-size: 0.7rem;
    padding: 0.2rem 0.5rem;
    border-radius: 10px;
    margin-right: 0.5rem;
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
            <i class="fas fa-comments text-primary mr-2"></i>
            Quản lý thảo luận
        </h1>
        <p class="text-muted">Quản lý và kiểm duyệt thảo luận từ cộng đồng</p>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Thảo luận</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="stats-card">
            <div class="stats-number">{{ number_format($discussions->total()) }}</div>
            <div class="stats-label">
                <i class="fas fa-comments mr-2"></i>Tổng thảo luận
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stats-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <div class="stats-number">{{ $discussions->where('status', 'open')->count() }}</div>
            <div class="stats-label">
                <i class="fas fa-unlock mr-2"></i>Đang mở
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stats-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div class="stats-number">{{ $discussions->where('status', 'solved')->count() }}</div>
            <div class="stats-label">
                <i class="fas fa-check-circle mr-2"></i>Đã giải quyết
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stats-card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
            <div class="stats-number">{{ $discussions->where('is_pinned', true)->count() }}</div>
            <div class="stats-label">
                <i class="fas fa-thumbtack mr-2"></i>Đã ghim
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card filter-card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.discussions.index') }}" class="row align-items-end">
            <div class="col-md-2">
                <label class="form-label font-weight-bold">
                    <i class="fas fa-folder mr-1"></i>Danh mục
                </label>
                <select name="category" class="form-control">
                    <option value="">Tất cả danh mục</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label font-weight-bold">
                    <i class="fas fa-book mr-1"></i>Khóa học
                </label>
                <select name="course" class="form-control">
                    <option value="">Tất cả khóa học</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ request('course') == $course->id ? 'selected' : '' }}>
                            {{ $course->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label font-weight-bold">
                    <i class="fas fa-filter mr-1"></i>Trạng thái
                </label>
                <select name="status" class="form-control">
                    <option value="">Tất cả</option>
                    <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Đang mở</option>
                    <option value="solved" {{ request('status') === 'solved' ? 'selected' : '' }}>Đã giải quyết</option>
                    <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Đã đóng</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label font-weight-bold">
                    <i class="fas fa-sort mr-1"></i>Sắp xếp
                </label>
                <select name="sort" class="form-control">
                    <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Mới nhất</option>
                    <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Phổ biến</option>
                    <option value="most_replies" {{ request('sort') === 'most_replies' ? 'selected' : '' }}>Nhiều trả lời</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label font-weight-bold">
                    <i class="fas fa-search mr-1"></i>Tìm kiếm
                </label>
                <input type="text" name="search" class="form-control" 
                       placeholder="Tìm theo tiêu đề, nội dung..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-search"></i>
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
                Danh sách thảo luận ({{ number_format($discussions->total()) }})
            </h5>
        </div>
        <div class="col-md-6 text-right">
            <button type="button" class="btn btn-warning btn-sm" onclick="bulkAction('close')">
                <i class="fas fa-lock mr-2"></i>Đóng đã chọn
            </button>
            <button type="button" class="btn btn-success btn-sm" onclick="bulkAction('open')">
                <i class="fas fa-unlock mr-2"></i>Mở đã chọn
            </button>
            <button type="button" class="btn btn-info btn-sm" onclick="bulkAction('pin')">
                <i class="fas fa-thumbtack mr-2"></i>Ghim đã chọn
            </button>
            <button type="button" class="btn btn-danger btn-sm" onclick="bulkAction('delete')">
                <i class="fas fa-trash mr-2"></i>Xóa đã chọn
            </button>
        </div>
    </div>
</div>

<!-- Discussions Table -->
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
                    <th>Thảo luận</th>
                    <th>Tác giả</th>
                    <th>Danh mục</th>
                    <th>Trạng thái</th>
                    <th>Thống kê</th>
                    <th>Ngày tạo</th>
                    <th style="width: 150px;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($discussions as $discussion)
                    <tr class="discussion-row">
                        <td>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="discussion_ids[]" value="{{ $discussion->id }}" 
                                       class="custom-control-input discussion-checkbox" id="discussion_{{ $discussion->id }}">
                                <label class="custom-control-label" for="discussion_{{ $discussion->id }}"></label>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-start">
                                <div>
                                    @if($discussion->is_pinned)
                                        <span class="pinned-badge">
                                            <i class="fas fa-thumbtack mr-1"></i>Ghim
                                        </span>
                                    @endif
                                    @if($discussion->is_featured)
                                        <span class="featured-badge">
                                            <i class="fas fa-star mr-1"></i>Nổi bật
                                        </span>
                                    @endif
                                    <div class="font-weight-bold text-dark">
                                        <a href="{{ route('admin.discussions.show', $discussion) }}" class="text-decoration-none">
                                            {{ Str::limit($discussion->title, 50) }}
                                        </a>
                                    </div>
                                    @if($discussion->course)
                                        <small class="text-muted">
                                            <i class="fas fa-book mr-1"></i>{{ $discussion->course->title }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ $discussion->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($discussion->user->name) . '&background=667eea&color=fff' }}" 
                                     alt="Avatar" class="user-avatar mr-2">
                                <div>
                                    <div class="font-weight-bold">{{ $discussion->user->name }}</div>
                                    <small class="text-muted">{{ $discussion->user->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="category-badge text-white" style="background-color: {{ $discussion->category->color }}">
                                @if($discussion->category->icon)
                                    <i class="{{ $discussion->category->icon }} mr-1"></i>
                                @endif
                                {{ $discussion->category->name }}
                            </span>
                        </td>
                        <td>
                            @if($discussion->status === 'open')
                                <span class="status-badge bg-success text-white">
                                    <i class="fas fa-unlock mr-1"></i>Đang mở
                                </span>
                            @elseif($discussion->status === 'solved')
                                <span class="status-badge bg-info text-white">
                                    <i class="fas fa-check mr-1"></i>Đã giải quyết
                                </span>
                            @else
                                <span class="status-badge bg-secondary text-white">
                                    <i class="fas fa-lock mr-1"></i>Đã đóng
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="small">
                                <div><i class="fas fa-thumbs-up text-success mr-1"></i>{{ $discussion->votes_count }} votes</div>
                                <div><i class="fas fa-comments text-primary mr-1"></i>{{ $discussion->replies_count }} trả lời</div>
                                <div><i class="fas fa-eye text-muted mr-1"></i>{{ number_format($discussion->views_count) }} lượt xem</div>
                            </div>
                        </td>
                        <td>
                            <div class="font-weight-bold">{{ $discussion->created_at->format('d/m/Y') }}</div>
                            <small class="text-muted">{{ $discussion->created_at->format('H:i') }}</small>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.discussions.show', $discussion) }}" 
                                   class="btn btn-info btn-sm" title="Xem chi tiết">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('discussions.show', $discussion->slug) }}" 
                                   class="btn btn-primary btn-sm" title="Xem công khai" target="_blank">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.discussions.toggle-pin', $discussion) }}" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-warning btn-sm" 
                                            title="{{ $discussion->is_pinned ? 'Bỏ ghim' : 'Ghim' }}">
                                        <i class="fas fa-thumbtack"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.discussions.destroy', $discussion) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Xóa thảo luận này?')" title="Xóa">
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
                                <i class="fas fa-comments"></i>
                                <h5>Không có thảo luận nào</h5>
                                <p>Chưa có thảo luận nào phù hợp với bộ lọc hiện tại.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </form>
    
    @if($discussions->hasPages())
        <div class="p-3 bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Hiển thị {{ $discussions->firstItem() }} - {{ $discussions->lastItem() }} 
                    trong tổng số {{ number_format($discussions->total()) }} thảo luận
                </div>
                <div>
                    {{ $discussions->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Select all functionality
    $('#selectAll').change(function() {
        $('.discussion-checkbox').prop('checked', this.checked);
    });

    // Individual checkbox change
    $('.discussion-checkbox').change(function() {
        const totalCheckboxes = $('.discussion-checkbox').length;
        const checkedCheckboxes = $('.discussion-checkbox:checked').length;
        
        if (checkedCheckboxes === 0) {
            $('#selectAll').prop('indeterminate', false).prop('checked', false);
        } else if (checkedCheckboxes === totalCheckboxes) {
            $('#selectAll').prop('indeterminate', false).prop('checked', true);
        } else {
            $('#selectAll').prop('indeterminate', true);
        }
    });
});

// Bulk actions
function bulkAction(action) {
    const checkedBoxes = document.querySelectorAll('.discussion-checkbox:checked');
    if (checkedBoxes.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Chưa chọn thảo luận',
            text: 'Vui lòng chọn ít nhất một thảo luận để thực hiện hành động này.',
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
        case 'close':
            title = 'Đóng thảo luận';
            text = `Bạn có chắc muốn đóng ${checkedBoxes.length} thảo luận đã chọn?`;
            icon = 'warning';
            confirmButtonText = 'Đóng';
            actionUrl = '{{ route("admin.discussions.bulk-action") }}';
            break;
        case 'open':
            title = 'Mở thảo luận';
            text = `Bạn có chắc muốn mở ${checkedBoxes.length} thảo luận đã chọn?`;
            icon = 'question';
            confirmButtonText = 'Mở';
            actionUrl = '{{ route("admin.discussions.bulk-action") }}';
            break;
        case 'pin':
            title = 'Ghim thảo luận';
            text = `Bạn có chắc muốn ghim ${checkedBoxes.length} thảo luận đã chọn?`;
            icon = 'question';
            confirmButtonText = 'Ghim';
            actionUrl = '{{ route("admin.discussions.bulk-action") }}';
            break;
        case 'delete':
            title = 'Xóa thảo luận';
            text = `Bạn có chắc muốn xóa ${checkedBoxes.length} thảo luận đã chọn? Hành động này không thể hoàn tác.`;
            icon = 'error';
            confirmButtonText = 'Xóa';
            actionUrl = '{{ route("admin.discussions.bulk-action") }}';
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
            
            // Add action input
            const actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'action';
            actionInput.value = action;
            form.appendChild(actionInput);
            
            form.action = actionUrl;
            form.submit();
        }
    });
}
</script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
@endsection
