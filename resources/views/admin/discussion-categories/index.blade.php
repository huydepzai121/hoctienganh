@extends('layouts.adminlte-pure')

@section('title', 'Quản lý danh mục thảo luận')

@push('styles')
<style>
.category-card {
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 1rem;
}

.category-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.category-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    margin-right: 1rem;
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

.action-buttons .btn {
    margin: 0 2px;
    border-radius: 6px;
    padding: 0.375rem 0.75rem;
}

.create-btn {
    background: linear-gradient(135deg, #28a745, #20c997);
    border: none;
    border-radius: 25px;
    padding: 0.75rem 2rem;
    color: white;
    font-weight: 600;
    transition: all 0.3s ease;
}

.create-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
    color: white;
}

.status-toggle {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.status-toggle input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 34px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

input:checked + .slider {
    background-color: #28a745;
}

input:checked + .slider:before {
    transform: translateX(26px);
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

.sort-handle {
    cursor: move;
    color: #6c757d;
    margin-right: 0.5rem;
}

.sort-handle:hover {
    color: #495057;
}
</style>
@endpush

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark font-weight-bold">
            <i class="fas fa-folder text-primary mr-2"></i>
            Quản lý danh mục thảo luận
        </h1>
        <p class="text-muted">Quản lý các danh mục cho hệ thống thảo luận</p>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Danh mục thảo luận</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="stats-card">
            <div class="stats-number">{{ number_format($categories->total()) }}</div>
            <div class="stats-label">
                <i class="fas fa-folder mr-2"></i>Tổng danh mục
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stats-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <div class="stats-number">{{ $categories->where('is_active', true)->count() }}</div>
            <div class="stats-label">
                <i class="fas fa-check-circle mr-2"></i>Đang hoạt động
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stats-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div class="stats-number">{{ $categories->where('is_active', false)->count() }}</div>
            <div class="stats-label">
                <i class="fas fa-pause-circle mr-2"></i>Tạm dừng
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stats-card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
            <div class="stats-number">{{ $categories->sum('discussions_count') }}</div>
            <div class="stats-label">
                <i class="fas fa-comments mr-2"></i>Tổng thảo luận
            </div>
        </div>
    </div>
</div>

<!-- Header Actions -->
<div class="row mb-4">
    <div class="col-md-6">
        <h4 class="font-weight-bold">
            <i class="fas fa-list mr-2 text-primary"></i>
            Danh sách danh mục ({{ number_format($categories->total()) }})
        </h4>
    </div>
    <div class="col-md-6 text-right">
        <a href="{{ route('admin.discussion-categories.create') }}" class="btn create-btn">
            <i class="fas fa-plus mr-2"></i>Tạo danh mục mới
        </a>
    </div>
</div>

<!-- Categories List -->
<div class="row">
    @forelse($categories as $category)
        <div class="col-lg-6 col-md-12">
            <div class="category-card card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-grip-vertical sort-handle"></i>
                                <div class="category-icon" style="background-color: {{ $category->color }}">
                                    @if($category->icon)
                                        <i class="{{ $category->icon }}"></i>
                                    @else
                                        <i class="fas fa-folder"></i>
                                    @endif
                                </div>
                                <div>
                                    <h5 class="mb-1 font-weight-bold">{{ $category->name }}</h5>
                                    @if($category->description)
                                        <p class="text-muted mb-2 small">{{ Str::limit($category->description, 80) }}</p>
                                    @endif
                                    <div class="small text-muted">
                                        <span class="mr-3">
                                            <i class="fas fa-comments mr-1"></i>
                                            {{ number_format($category->discussions_count) }} thảo luận
                                        </span>
                                        <span class="mr-3">
                                            <i class="fas fa-sort mr-1"></i>
                                            Thứ tự: {{ $category->sort_order }}
                                        </span>
                                        <span>
                                            <i class="fas fa-calendar mr-1"></i>
                                            {{ $category->created_at->format('d/m/Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-right">
                                <!-- Status Toggle -->
                                <div class="mb-2">
                                    <label class="status-toggle">
                                        <input type="checkbox" 
                                               {{ $category->is_active ? 'checked' : '' }}
                                               onchange="toggleStatus({{ $category->id }})">
                                        <span class="slider"></span>
                                    </label>
                                    <small class="d-block text-muted">
                                        {{ $category->is_active ? 'Hoạt động' : 'Tạm dừng' }}
                                    </small>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="action-buttons">
                                    <a href="{{ route('admin.discussion-categories.show', $category) }}" 
                                       class="btn btn-info btn-sm" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.discussion-categories.edit', $category) }}" 
                                       class="btn btn-primary btn-sm" title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($category->discussions_count == 0)
                                        <form method="POST" action="{{ route('admin.discussion-categories.destroy', $category) }}" 
                                              style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('Xóa danh mục này?')" title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-secondary btn-sm" disabled title="Không thể xóa danh mục có thảo luận">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="empty-state">
                <i class="fas fa-folder"></i>
                <h5>Chưa có danh mục nào</h5>
                <p>Hãy tạo danh mục đầu tiên cho hệ thống thảo luận.</p>
                <a href="{{ route('admin.discussion-categories.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus mr-2"></i>Tạo danh mục đầu tiên
                </a>
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($categories->hasPages())
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Hiển thị {{ $categories->firstItem() }} - {{ $categories->lastItem() }} 
                    trong tổng số {{ number_format($categories->total()) }} danh mục
                </div>
                <div>
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
@endif

@push('scripts')
<script>
// Toggle category status
function toggleStatus(categoryId) {
    $.ajax({
        url: `/admin/discussion-categories/${categoryId}/toggle-status`,
        method: 'PATCH',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            // Show success message
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: 'Trạng thái danh mục đã được cập nhật.',
                timer: 2000,
                showConfirmButton: false
            });
            
            // Reload page after a short delay
            setTimeout(() => {
                location.reload();
            }, 2000);
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: 'Có lỗi xảy ra. Vui lòng thử lại.',
                confirmButtonColor: '#dc3545'
            });
            
            // Revert toggle state
            location.reload();
        }
    });
}

// Sortable functionality (if needed)
$(document).ready(function() {
    // Add sortable functionality here if you want drag & drop reordering
    // This would require additional backend support for updating sort_order
});

// Add hover effects
$('.category-card').hover(
    function() {
        $(this).addClass('shadow-lg');
    },
    function() {
        $(this).removeClass('shadow-lg');
    }
);
</script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
@endsection
